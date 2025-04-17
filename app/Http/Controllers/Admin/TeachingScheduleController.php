<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeachingSchedule;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeachingScheduleController extends Controller
{
    public function index()
    {
        $schedules = TeachingSchedule::with(['teacher', 'subject', 'academicLevel'])
            ->latest()
            ->paginate(10);
            
        // Changed from 'create' to 'index' view
        return view('admin.teachers.schedules.index', compact('schedules'));
    }

    public function create()
    {
        try {
            // Use the getFullNameAttribute from Teacher model
            $teachers = Teacher::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            $subjects = Subject::select('id', 'name')
                ->orderBy('name')
                ->get();

            $academicLevels = AcademicLevel::select('id', 'name', 'order')
                ->orderBy('order')
                ->get();

            // Debug information
            \Log::info('Create method data:', [
                'teacherCount' => $teachers->count(),
                'subjectCount' => $subjects->count(),
                'academicLevelCount' => $academicLevels->count()
            ]);

            return view('admin.teachers.schedules.create', compact(
                'teachers',
                'subjects',
                'academicLevels'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in create method:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('admin.teachers.schedules.index')
                ->with('error', 'Error loading creation form');
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'subject_id' => 'required|exists:subjects,id',
                'academic_level_id' => 'required|exists:academic_levels,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
                'start_time' => 'required|date_format:H:i',
                'room_number' => 'required|string',
                'wing' => 'required|in:A,B',
                'academic_year' => 'sometimes|string',
                'term' => 'sometimes|in:1,2,3'
            ]);

            // Set default values if not provided
            $validated['academic_year'] = $request->academic_year ?? date('Y').'-'.(date('Y')+1);
            $validated['term'] = $request->term ?? '1';

            // Calculate end time (2 hours after start time)
            $startTime = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
            $endTime = $startTime->copy()->addHours(2);
            $validated['end_time'] = $endTime->format('H:i');

            TeachingSchedule::create($validated);

            DB::commit();
            return redirect()
                ->route('admin.teachers.schedules.index')
                ->with('success', 'Teaching schedule created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Schedule creation error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'inputs' => $request->all()
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(TeachingSchedule $schedule)
    {
        $teachers = Teacher::where('is_active', true)
            ->orderBy('first_name')
            ->get();
            
        $subjects = Subject::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $academicLevels = AcademicLevel::where('is_active', true)
            ->orderBy('order')
            ->get();
            
        return view('admin.teachers.schedules.edit', 
            compact('schedule', 'teachers', 'subjects', 'academicLevels'));
    }

    public function update(Request $request, TeachingSchedule $schedule)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id',
                'subject_id' => 'required|exists:subjects,id',
                'academic_level_id' => 'required|exists:academic_levels,id',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday',
                'start_time' => 'required|date_format:H:i',
                'room_number' => 'required|string',
                'wing' => 'required|in:A,B',
            ]);

            $startTime = \Carbon\Carbon::createFromFormat('H:i', $validated['start_time']);
            $endTime = $startTime->copy()->addHours(2);

            $schedule->update([
                'teacher_id' => $validated['teacher_id'],
                'subject_id' => $validated['subject_id'],
                'academic_level_id' => $validated['academic_level_id'],
                'day_of_week' => $validated['day_of_week'],
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'room_number' => $validated['room_number'],
                'wing' => $validated['wing']
            ]);

            DB::commit();
            return redirect()->route('admin.teachers.schedules.index')
                ->with('success', 'Teaching schedule updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Schedule update error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withInput()
                ->withErrors(['error' => 'Error updating schedule. Please try again.']);
        }
    }

    public function destroy(TeachingSchedule $schedule)
    {
        try {
            $schedule->delete();
            return redirect()->route('admin.teachers.schedules.index')
                ->with('success', 'Teaching schedule deleted successfully');
        } catch (\Exception $e) {
            Log::error('Schedule deletion error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error deleting schedule');
        }
    }

    public function show(TeachingSchedule $schedule)
    {
        try {
            $schedule->load(['teacher', 'subject', 'academicLevel']);
            
            return view('admin.teachers.schedules.show', compact('schedule'));
            
        } catch (\Exception $e) {
            Log::error('Error showing schedule:', [
                'schedule_id' => $schedule->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()
                ->route('admin.teachers.schedules.index')
                ->with('error', 'Error loading schedule details');
        }
    }
}