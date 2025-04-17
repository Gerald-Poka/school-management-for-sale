<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasStudentProfile
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user() || !auth()->user()->student) {
            return redirect()->route('home')->with('error', 'Student profile not found.');
        }

        return $next($request);
    }
}