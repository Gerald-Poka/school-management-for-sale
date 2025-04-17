<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            SubjectsTableSeeder::class,
            AcademicLevelSeeder::class,
            GuardianSeeder::class,
            FeeTypeSeeder::class,
            FeeStructureSeeder::class,
            StudentSeeder::class,
            StandardOneTimetableSeeder::class
        ]);
    }
}
