<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    public function creating(Student $student)
    {
        // Remove any user creation logic from here
        // The user is already created in the StudentController
        return true;
    }

    public function created(Student $student)
    {
        // You can add any post-creation logic here if needed
    }
}