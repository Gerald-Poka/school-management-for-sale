<?php

namespace Database\Seeders;

use App\Models\FeeStructure;
use App\Models\FeeType;
use App\Models\AcademicLevel;
use Illuminate\Database\Seeder;

class FeeStructureSeeder extends Seeder
{
    public function run(): void
    {
        $feeTypes = FeeType::all();
        $academicLevels = AcademicLevel::all();

        foreach ($academicLevels as $level) {
            foreach ($feeTypes as $feeType) {
                $baseAmount = match ($feeType->code) {
                    'TF' => 500000, // Base tuition fee
                    'RF' => 50000,  // Registration fee
                    'DF' => 100000, // Development fee
                    'LF' => 30000,  // Library fee
                    default => 0,
                };

                // Increase amount by 50,000 for each higher level
                $amount = $baseAmount + (($level->order - 1) * 50000);

                FeeStructure::create([
                    'fee_type_id' => $feeType->id,
                    'academic_level_id' => $level->id,
                    'amount' => $amount,
                    'effective_from' => '2024-01-01',
                    'effective_to' => '2024-12-31',
                    'is_active' => true,
                ]);
            }
        }
    }
}