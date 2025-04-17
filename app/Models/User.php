<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
        'last_login_at',
        'phone',
        'address',
        'profile_photo',
        'employee_id',
        'department',
        'joined_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
        'joined_date' => 'date',
    ];

    protected $dates = [
        'last_login',
        'created_at',
        'updated_at'
    ];

    // Role constants
    const ROLE_ADMIN = 'admin';
    const ROLE_TEACHER = 'teacher';
    const ROLE_SUPERVISOR = 'supervisor';
    const ROLE_USER = 'user';

    // Helper methods to check roles
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function isTeacher()
    {
        return $this->hasRole(self::ROLE_TEACHER);
    }

    public function isSupervisor()
    {
        return $this->hasRole(self::ROLE_SUPERVISOR);
    }

    public function isUser()
    {
        return $this->hasRole(self::ROLE_USER);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}