<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\AcademicLevel;
use App\Models\FeeType;
use Illuminate\Http\Request;

class OtherFeeController extends Controller
{
    public function index()
    {
        $otherFees = FeeStructure::with(['academicLevel', 'feeType'])
            ->whereHas('feeType', function($query) {
                $query->whereNotIn('code', ['TUT', 'TRANS']);
            })
            ->orderBy('academic_level_id')
            ->get();

        return view('admin.finance.other-fees.index', compact('otherFees'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        $feeTypes = FeeType::whereNotIn('code', ['TUT', 'TRANS'])->get();
        return view('admin.finance.other-fees.create', compact('academicLevels', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'required|boolean'
        ]);

        FeeStructure::create($validated);

        return redirect()->route('admin.finance.other-fees')
            ->with('success', 'Other fee structure created successfully.');
    }

    public function edit(FeeStructure $otherFee)
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        $feeTypes = FeeType::whereNotIn('code', ['TUT', 'TRANS'])->get();
        return view('admin.finance.other-fees.edit', compact('otherFee', 'academicLevels', 'feeTypes'));
    }

    public function update(Request $request, FeeStructure $otherFee)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'required|boolean'
        ]);

        $otherFee->update($validated);

        return redirect()->route('admin.finance.other-fees')
            ->with('success', 'Other fee structure updated successfully.');
    }

    public function destroy(FeeStructure $otherFee)
    {
        $otherFee->delete();
        return redirect()->route('admin.finance.other-fees')
            ->with('success', 'Other fee structure deleted successfully.');
    }
}