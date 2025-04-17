<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use App\Models\Guardian;
use App\Models\AcademicLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create some guardians first
        $guardians = $this->createGuardians();
        
        // Get all academic levels
        $academicLevels = AcademicLevel::all();

        // Sample student data
        $students = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'gender' => 'male',
                'date_of_birth' => '2016-05-15',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'gender' => 'female',
                'date_of_birth' => '2016-08-22',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'gender' => 'male',
                'date_of_birth' => '2015-11-30',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'gender' => 'female',
                'date_of_birth' => '2017-02-10',
            ],
        ];

        foreach ($students as $studentData) {
            // Create user account
            $user = User::create([
                'name' => $studentData['first_name'] . ' ' . $studentData['last_name'],
                'email' => Str::slug($studentData['first_name'] . $studentData['last_name']) . '@school.com',
                'username' => strtolower($studentData['first_name'] . $studentData['last_name']),
                'password' => bcrypt('password123'),
                'role' => 'student',
                'is_active' => true,
            ]);

            // Create student record
            Student::create([
                'admission_number' => 'STD' . date('Y') . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'date_of_birth' => $studentData['date_of_birth'],
                'gender' => $studentData['gender'],
                'academic_level_id' => $academicLevels->random()->id,
                'guardian_id' => $guardians->random()->id,
                'user_id' => $user->id,
                'date_of_admission' => now(),
                'is_active' => true,
            ]);
        }
    }

    private function createGuardians()
    {
        $guardians = collect([
            [
                'full_name' => 'Robert Doe',
                'relationship' => 'father',
                'primary_phone' => '255712345678',
                'email' => 'robert.doe@example.com',
                'residential_address' => 'Kinondoni, Dar es Salaam',
                'occupation' => 'Engineer',
            ],
            [
                'full_name' => 'Mary Smith',
                'relationship' => 'mother',
                'primary_phone' => '255787654321',
                'email' => 'mary.smith@example.com',
                'residential_address' => 'Ilala, Dar es Salaam',
                'occupation' => 'Doctor',
            ],
        ]);

        return $guardians->map(function ($guardian) {
            return Guardian::create($guardian);
        });
    }
}
