<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
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

        // Match the query from SubjectController
        $subjects = Subject::where('level', 'Standard ' . $student->academicLevel->order)
            ->with(['results' => function($query) use ($student) {
                $query->where('student_id', $student->id);
            }])
            ->get();

        return view('student.results.index', compact('subjects'));
    }
}