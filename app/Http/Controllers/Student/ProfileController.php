<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Guardian;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->with('guardian')->first();
        return view('student.profile.index', compact('user', 'student'));
    }

    public function edit()
    {
        return view('student.profile.edit');
    }

    public function update(Request $request)
    {
        // Add validation and update logic here
        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}