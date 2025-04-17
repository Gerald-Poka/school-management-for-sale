<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (!$user->is_active) {
            auth()->logout();
            return back()->with('error', 'Your account is not active.');
        }

        // Log the authentication attempt for debugging
        Log::info('User authentication successful', [
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        // Update last login timestamp
        $user->update([
            'last_login_at' => now(),
            'last_login' => now()
        ]);

        // Role-based redirection
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            case 'teacher':
                return redirect()->intended(route('teacher.dashboard'));
            case 'student':
                return redirect()->intended(route('student.dashboard'));
            default:
                auth()->logout();
                return redirect()->route('login')->with('error', 'Invalid role assigned.');
        }
    }

    // Use email for authentication
    public function username()
    {
        return 'email';
    }
}