<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student profile not found.');
        }

        if (!$student->academicLevel) {
            return redirect()->back()->with('error', 'Academic level not assigned.');
        }

        $timetable = Timetable::with(['slots' => function($query) {
            $query->orderBy('day_of_week')
                  ->orderBy('start_time')
                  ->with(['subject', 'teacher']);
        }])
        ->where('academic_level_id', $student->academic_level_id)
        ->where('is_active', true)
        ->first();

        $timeSlots = Timetable::generateTimeSlots();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return view('student.timetable.index', compact('timetable', 'timeSlots', 'days'));
    }
}