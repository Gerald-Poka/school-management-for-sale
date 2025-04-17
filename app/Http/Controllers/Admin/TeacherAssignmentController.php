<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\TeacherAssignment;
use App\Models\AcademicLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TeacherAssignment::with(['teacher', 'subject', 'academicLevel'])
            ->latest()
            ->paginate(10);
            
        return view('admin.teachers.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('first_name')
            ->orderBy('last_name')
            ->get();
            
        // Remove is_active check from subjects query
        $subjects = Subject::orderBy('name')->get();
        
        $academicLevels = AcademicLevel::orderBy('order')->get();
        
        return view('admin.teachers.assignments.create', 
            compact('teachers', 'subjects', 'academicLevels'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'subject_id' => 'required|exists:subjects,id',
                'academic_level_id' => 'required|exists:academic_levels,id',
                'academic_year' => 'required|string|regex:/^\d{4}-\d{4}$/',
                'term' => 'required|in:1,2,3'
            ]);

            // Check for duplicate assignments
            $exists = TeacherAssignment::where('teacher_id', $validated['teacher_id'])
                ->where('subject_id', $validated['subject_id'])
                ->where('academic_level_id', $validated['academic_level_id'])
                ->where('academic_year', $validated['academic_year'])
                ->where('term', $validated['term'])
                ->exists();

            if ($exists) {
                throw new \Exception('This assignment already exists for the selected term and academic year.');
            }

            TeacherAssignment::create($validated);
            
            DB::commit();
            return redirect()->route('admin.teachers.assignments.index')
                ->with('success', 'Teacher assignment created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Assignment creation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Error creating assignment: ' . $e->getMessage());
        }
    }

    public function destroy(TeacherAssignment $assignment)
    {
        try {
            DB::beginTransaction();
            
            $assignment->delete();
            
            DB::commit();
            return redirect()->route('admin.teachers.assignments.index')
                ->with('success', 'Teacher assignment deleted successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Assignment deletion error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error deleting assignment: ' . $e->getMessage());
        }
    }

    public function teacherAssignments(Teacher $teacher)
    {
        $assignments = TeacherAssignment::where('teacher_id', $teacher->id)
            ->with(['subject', 'academicLevel'])
            ->latest()
            ->paginate(10);
            
        return view('admin.teachers.assignments.index', 
            compact('assignments', 'teacher'));
    }
}