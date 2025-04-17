<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
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

        $subjects = Subject::where('level', 'Standard ' . $student->academicLevel->order)->get();

        return view('student.subjects.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
        return view('student.subjects.show', compact('subject'));
    }

    public function viewPdf(Subject $subject)
    {
        if (!$subject->pdf_link || !file_exists(public_path($subject->pdf_link))) {
            return back()->with('error', 'PDF document not available.');
        }

        return response()->file(public_path($subject->pdf_link));
    }
}