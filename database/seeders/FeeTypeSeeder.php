<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    public function run(): void
    {
        $feeTypes = [
            [
                'name' => 'Tuition Fee',
                'code' => 'TUT',
                'frequency' => 'term',
                'description' => 'Regular tuition fee charged per term',
                'is_active' => true
            ],
            [
                'name' => 'Transport Fee',
                'code' => 'TRANS',
                'frequency' => 'term',
                'description' => 'School transport service fee',
                'is_active' => true
            ],
            [
                'name' => 'Registration Fee',
                'code' => 'REG',
                'frequency' => 'one_time',
                'description' => 'One-time registration fee',
                'is_active' => true
            ]
        ];

        foreach ($feeTypes as $feeType) {
            FeeType::updateOrCreate(
                ['code' => $feeType['code']],
                $feeType
            );
        }
    }
}