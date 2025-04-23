<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Student;
use App\Models\AcademicLevel;

class ResultController extends Controller
{
    public function index()
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        $subjects = Subject::orderBy('name')->get();
        
        $results = Result::with(['student.academicLevel', 'subject'])
            ->when(request('academic_level'), function($query) {
                $query->whereHas('student.academicLevel', function($q) {
                    $q->where('order', request('academic_level'));
                });
            })
            ->when(request('subject_id'), function($query) {
                $query->where('subject_id', request('subject_id'));
            })
            ->when(request('exam_type'), function($query) {
                $query->where('exam_type', request('exam_type'));
            })
            ->latest('exam_date')
            ->paginate(25);
        
        return view('admin.results.index', compact('results', 'academicLevels', 'subjects'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        $subjects = Subject::all();
        
        // Get selected academic level from query parameter
        $selectedLevel = request('academic_level');
        $students = collect();

        if ($selectedLevel) {
            $students = Student::whereHas('academicLevel', function($query) use ($selectedLevel) {
                $query->where('order', $selectedLevel);
            })->get();
        }

        return view('admin.results.create', compact('academicLevels', 'subjects', 'students', 'selectedLevel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam_type' => 'required|string',
            'marks_obtained' => 'required|numeric|min:0|max:100',
            'grade' => 'required|string',
            'exam_date' => 'required|date',
            'remarks' => 'nullable|string'
        ]);

        Result::create($request->all());

        return redirect()->route('admin.results.index')
            ->with('success', 'Result uploaded successfully');
    }

    public function destroy(Result $result)
    {
        $result->delete();
        return redirect()->route('admin.results.index')
            ->with('success', 'Result deleted successfully');
    }

    public function getStudentsByLevel($level)
    {
        $students = Student::whereHas('academicLevel', function($query) use ($level) {
            $query->where('name', 'Standard ' . $level);
        })->get(['id', 'first_name', 'last_name', 'admission_number']);

        return response()->json($students);
    }
}