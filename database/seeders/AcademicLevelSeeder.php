<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicLevel;

class AcademicLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Standard One',
                'code' => 'STD1',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Two',
                'code' => 'STD2',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Three',
                'code' => 'STD3',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Four',
                'code' => 'STD4',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Five',
                'code' => 'STD5',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Standard Six',
                'code' => 'STD6',
                'order' => 6,
                'is_active' => true,
            ]
        ];

        foreach ($levels as $level) {
            AcademicLevel::create($level);
        }
    }
}