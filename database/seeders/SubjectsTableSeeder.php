<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            [
                'name' => 'Mathematics',
                'code' => 'MATH101',
                'description' => 'Basic mathematics for primary education',
                'credits' => 4,
                'level' => 'Standard 1',
                'pdf_link' => null
            ],
            [
                'name' => 'English Language',
                'code' => 'ENG101',
                'description' => 'Fundamental English language skills',
                'credits' => 4,
                'level' => 'Standard 1',
                'pdf_link' => null
            ],
            [
                'name' => 'Science',
                'code' => 'SCI101',
                'description' => 'Basic science concepts',
                'credits' => 4,
                'level' => 'Standard 1',
                'pdf_link' => null
            ],
            [
                'name' => 'Kiswahili',
                'code' => 'KIS101',
                'description' => 'Kiswahili language fundamentals',
                'credits' => 4,
                'level' => 'Standard 1',
                'pdf_link' => null
            ]
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                ['code' => $subject['code']], // Check if exists by code
                $subject // Data to update or create
            );
        }
    }
}