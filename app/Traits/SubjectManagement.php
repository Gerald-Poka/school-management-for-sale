<?php

namespace App\Traits;

trait SubjectManagement
{
    protected function getSubjectsPerLevel(): array
    {
        return [
            'Standard 1' => [
                'Mathematics',
                'Kiswahili',
                'Social Studies',
                'Environmental Education',
                'Religious Studies',
                'Vocational Skills',
                'Arts and Sports',
                'English'
            ],
            'Standard 2' => [
                'Mathematics',
                'Kiswahili',
                'Social Studies',
                'Environmental Education',
                'Religious Studies',
                'Vocational Skills',
                'Arts and Sports',
                'English'
            ],
            'Standard 3' => [
                'Mathematics',
                'Kiswahili',
                'English',
                'Science and Technology',
                'Social Studies',
                'Religious Studies',
                'Vocational Skills',
                'Arts and Sports'
            ],
            'Standard 4' => [
                'Mathematics',
                'Kiswahili',
                'English',
                'Science and Technology',
                'Social Studies',
                'Religious Studies',
                'Vocational Skills',
                'Arts and Sports'
            ],
            'Standard 5' => [
                'Mathematics',
                'Kiswahili',
                'English',
                'Science and Technology',
                'Social Studies',
                'Religious Studies',
                'Vocational Skills and Business',
                'Arts and Sports',
                'Civics and Ethics'
            ],
            'Standard 6' => [
                'Mathematics',
                'Kiswahili',
                'English',
                'Science and Technology',
                'Social Studies',
                'Religious Studies',
                'Vocational Skills and Business',
                'Arts and Sports',
                'Civics and Ethics'
            ]
        ];
    }

    protected function generateSubjectCode(string $subjectName, string $level): string
    {
        // Extract standard number from level
        $standardNum = filter_var($level, FILTER_SANITIZE_NUMBER_INT);
        
        // Get first letters of each word in subject name
        $nameCode = implode('', array_map(function($word) {
            return strtoupper(substr($word, 0, 1));
        }, explode(' ', $subjectName)));

        // Generate unique code: STD{number}{subject initials}{random 2 digits}
        return sprintf('STD%s%s%02d', 
            $standardNum,
            $nameCode,
            rand(10, 99)
        );
    }
}