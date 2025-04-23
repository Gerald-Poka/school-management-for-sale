<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\TimetableSlot;
use App\Models\AcademicLevel;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimetableController extends Controller
{
    public function index()
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        $timetables = Timetable::with(['academicLevel', 'slots.subject', 'slots.teacher'])
            ->where('is_active', true)
            ->get();

        return view('admin.timetables.index', compact('academicLevels', 'timetables'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('order')->get();
        $subjects = Subject::orderBy('name')->get();
        $timeSlots = Timetable::generateTimeSlots();
        
        return view('admin.timetables.create', compact(
            'academicLevels',
            'subjects',
            'timeSlots'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $timetable = Timetable::create([
                'academic_level_id' => $request->academic_level_id,
                'academic_year' => $request->academic_year,
                'term' => $request->term,
                'is_active' => true
            ]);

            // Generate slots for each day
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day) {
                foreach (Timetable::generateTimeSlots() as $timeSlot) {
                    $type = 'class';
                    if ($timeSlot[0] === '10:45') $type = 'break';
                    if ($timeSlot[0] === '13:15') $type = 'lunch';

                    TimetableSlot::create([
                        'timetable_id' => $timetable->id,
                        'day_of_week' => $day,
                        'start_time' => $timeSlot[0],
                        'end_time' => $timeSlot[1],
                        'type' => $type,
                        'room_number' => rand(1, 20) // Random room for demo
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.timetables.edit', $timetable)
                ->with('success', 'Timetable created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function getAvailableTeachers(TimetableSlot $slot)
    {
        try {
            $availableTeachers = Teacher::whereHas('assignments', function($query) use ($slot) {
                $query->where('subject_id', $slot->subject_id)
                      ->where('academic_level_id', $slot->timetable->academic_level_id)
                      ->where('is_active', true);
            })
            ->whereDoesntHave('timetableSlots', function($query) use ($slot) {
                $query->where('day_of_week', $slot->day_of_week)
                      ->where('type', 'class')
                      ->groupBy('teacher_id')
                      ->havingRaw('COUNT(*) >= 4');
            })
            ->whereDoesntHave('timetableSlots', function($query) use ($slot) {
                $query->where('day_of_week', $slot->day_of_week)
                      ->where('start_time', $slot->start_time);
            })
            ->select('id', 'first_name', 'last_name')
            ->get();

            if ($availableTeachers->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No teachers available for this subject at this time'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $availableTeachers
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching available teachers:', [
                'error' => $e->getMessage(),
                'slot_id' => $slot->id
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Error loading available teachers'
            ], 500);
        }
    }

    public function showAssign(TimetableSlot $slot)
    {
        try {
            // Get teachers assigned to this specific subject
            $availableTeachers = Teacher::whereHas('assignments', function($query) use ($slot) {
                $query->where('subject_id', $slot->subject_id)
                      ->where('is_active', true);
            })
            ->with(['assignments' => function($query) use ($slot) {
                $query->where('subject_id', $slot->subject_id);
            }])
            ->select('id', 'first_name', 'last_name')
            ->get();

            // Get timetables and other required data
            $academicLevels = AcademicLevel::orderBy('order')->get();
            $timetables = Timetable::with(['academicLevel', 'slots.subject', 'slots.teacher'])
                ->where('is_active', true)
                ->get();

            return view('admin.timetables.index', compact('academicLevels', 'timetables', 'availableTeachers', 'slot'));

        } catch (\Exception $e) {
            Log::error('Error loading teachers:', [
                'slot_id' => $slot->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error loading available teachers');
        }
    }

    public function assignTeacher(Request $request, TimetableSlot $slot)
    {
        try {
            DB::beginTransaction();

            // Validate request
            $validated = $request->validate([
                'teacher_id' => 'required|exists:teachers,id'
            ]);

            // Check if teacher already has a class at this time
            $hasConflict = TimetableSlot::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $slot->day_of_week)
                ->where('start_time', $slot->start_time)
                ->exists();

            if ($hasConflict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher already has a class at this time'
                ], 422);
            }

            // Check if teacher has reached max classes for the day
            $classCount = TimetableSlot::where('teacher_id', $validated['teacher_id'])
                ->where('day_of_week', $slot->day_of_week)
                ->where('type', 'class')
                ->count();

            if ($classCount >= 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teacher has reached maximum classes for this day'
                ], 422);
            }

            // Update the slot with teacher
            $slot->update([
                'teacher_id' => $validated['teacher_id']
            ]);

            // Create or update teaching schedule
            TeachingSchedule::updateOrCreate(
                [
                    'teacher_id' => $validated['teacher_id'],
                    'subject_id' => $slot->subject_id,
                    'academic_level_id' => $slot->timetable->academic_level_id,
                    'day_of_week' => $slot->day_of_week,
                    'start_time' => $slot->start_time,
                ],
                [
                    'end_time' => $slot->end_time,
                    'room_number' => $slot->room_number,
                    'academic_year' => $slot->timetable->academic_year,
                    'term' => $slot->timetable->term,
                    'is_active' => true
                ]
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Teacher assigned successfully',
                'teacher' => [
                    'id' => $slot->teacher->id,
                    'name' => $slot->teacher->first_name . ' ' . $slot->teacher->last_name
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Teacher assignment error:', [
                'message' => $e->getMessage(),
                'slot_id' => $slot->id,
                'teacher_id' => $request->teacher_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error assigning teacher: ' . $e->getMessage()
            ], 500);
        }
    }
    public function edit(Timetable $timetable)
{
    $academicLevels = AcademicLevel::orderBy('order')->get();
    $subjects = Subject::orderBy('name')->get();
    $timeSlots = Timetable::generateTimeSlots();
    
    // Get existing slot data
    $slotData = [];
    foreach ($timetable->slots as $slot) {
        if ($slot->type === 'class') {
            $slotData[$slot->day_of_week][$slot->start_time] = [
                'subject_id' => $slot->subject_id,
                'teacher_id' => $slot->teacher_id,
                'slot_id' => $slot->id
            ];
        }
    }
    
    return view('admin.timetables.edit', compact(
        'timetable',
        'academicLevels',
        'subjects',
        'timeSlots',
        'slotData'
    ));
}


    public function getSubjectTeachers(TimetableSlot $slot)
    {
        try {
            // Get teachers assigned to this subject and academic level
            $teachers = Teacher::whereHas('assignments', function($query) use ($slot) {
                $query->where('subject_id', $slot->subject_id)
                      ->where('academic_level_id', $slot->timetable->academic_level_id)
                      ->where('is_active', true);
            })
            // Check teacher's schedule conflicts
            ->whereDoesntHave('schedules', function($query) use ($slot) {
                $query->where('day_of_week', $slot->day_of_week)
                      ->where(function($q) use ($slot) {
                          $q->whereBetween('start_time', [$slot->start_time, $slot->end_time])
                            ->orWhereBetween('end_time', [$slot->start_time, $slot->end_time]);
                      });
            })
            // Limit to teachers with less than 4 classes per day
            ->withCount(['schedules' => function($query) use ($slot) {
                $query->where('day_of_week', $slot->day_of_week);
            }])
            ->having('schedules_count', '<', 4)
            ->with(['schedules' => function($query) {
                $query->orderBy('day_of_week')
                      ->orderBy('start_time');
            }])
            ->get();

            return response()->json([
                'success' => true,
                'teachers' => $teachers
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching subject teachers:', [
                'slot_id' => $slot->id,
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error loading available teachers'
            ], 500);
        }
    }
}