<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timetable;
use App\Models\TimetableSlot;
use App\Models\AcademicLevel;
use App\Models\Subject;

class StandardOneTimetableSeeder extends Seeder
{
    public function run(): void
    {
        try {
            // Find Standard One academic level
            $standardOne = AcademicLevel::where('name', 'like', '%Standard One%')->first();
            if (!$standardOne) {
                throw new \Exception('Standard One not found in academic_levels table');
            }

            // Create timetable
            $timetable = Timetable::create([
                'academic_level_id' => $standardOne->id,
                'academic_year' => '2025-2026',
                'term' => '1',
                'is_active' => true
            ]);

            // Get subjects
            $subjects = Subject::all();
            if ($subjects->isEmpty()) {
                throw new \Exception('No subjects found in subjects table');
            }

            // Define time slots
            $timeSlots = [
                ['08:45', '09:45'],
                ['09:45', '10:45'],
                ['10:45', '11:15'], // Break
                ['11:15', '12:15'],
                ['12:15', '13:15'],
                ['13:15', '14:15'], // Lunch
                ['14:15', '15:15'],
                ['15:15', '16:15']
            ];

            // Create slots for each day
            foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day) {
                foreach ($timeSlots as $index => $time) {
                    $type = 'class';
                    $subjectId = null;

                    // Set break and lunch periods
                    if ($time[0] === '10:45') {
                        $type = 'break';
                    } elseif ($time[0] === '13:15') {
                        $type = 'lunch';
                    } else {
                        // Randomly assign subjects for class periods
                        $subjectId = $subjects->random()->id;
                    }

                    TimetableSlot::create([
                        'timetable_id' => $timetable->id,
                        'subject_id' => $subjectId,
                        'day_of_week' => $day,
                        'start_time' => $time[0],
                        'end_time' => $time[1],
                        'room_number' => $type === 'class' ? 'Room ' . rand(1, 10) : null,
                        'type' => $type
                    ]);
                }
            }

            echo "Standard One timetable created successfully!\n";

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}