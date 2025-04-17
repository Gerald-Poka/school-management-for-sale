<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        $user = auth()->user();
        
        if (!in_array($user->role, $roles)) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}