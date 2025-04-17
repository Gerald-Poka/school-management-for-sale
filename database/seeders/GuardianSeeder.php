<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    public function run(): void
    {
        $guardians = [
            [
                'full_name' => 'John Doe',
                'relationship' => 'father',
                'primary_phone' => '255712345678',
                'alternative_phone' => '255787654321',
                'email' => 'john.doe@example.com',
                'residential_address' => 'Plot 123, Kinondoni Street, Dar es Salaam',
                'occupation' => 'Business Owner',
                'is_emergency_contact' => true
            ],
            [
                'full_name' => 'Mary Smith',
                'relationship' => 'mother',
                'primary_phone' => '255723456789',
                'alternative_phone' => '255789876543',
                'email' => 'mary.smith@example.com',
                'residential_address' => '45 Msasani Road, Dar es Salaam',
                'occupation' => 'Teacher',
                'is_emergency_contact' => true
            ],
            [
                'full_name' => 'Robert Wilson',
                'relationship' => 'guardian',
                'primary_phone' => '255734567890',
                'email' => 'robert.wilson@example.com',
                'residential_address' => '78 Kariakoo Street, Dar es Salaam',
                'occupation' => 'Doctor',
                'is_emergency_contact' => false
            ]
        ];

        foreach ($guardians as $guardian) {
            Guardian::updateOrCreate(
                ['primary_phone' => $guardian['primary_phone']],
                $guardian
            );
        }
    }
}