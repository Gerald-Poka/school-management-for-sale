<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\AcademicLevel;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $feeStructures = FeeStructure::with(['academicLevel', 'feeType'])
            ->orderBy('academic_level_id')
            ->get();
        return view('admin.finance.fee-structures.index', compact('feeStructures'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        $feeTypes = FeeType::orderBy('name')->get();
        return view('admin.finance.fee-structures.create', compact('academicLevels', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0|max:999999999.99',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'required|boolean'
        ]);

        FeeStructure::create($validated);

        return redirect()->route('admin.finance.fee-structures.index')
            ->with('success', 'Fee structure created successfully.');
    }

    public function edit(FeeStructure $feeStructure)
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        $feeTypes = FeeType::orderBy('name')->get();
        return view('admin.finance.fee-structures.edit', 
            compact('feeStructure', 'academicLevels', 'feeTypes'));
    }

    public function update(Request $request, FeeStructure $feeStructure)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'fee_type_id' => 'required|exists:fee_types,id',
            'amount' => 'required|numeric|min:0|max:999999999.99',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'required|boolean'
        ]);

        $feeStructure->update($validated);

        return redirect()->route('admin.finance.fee-structures.index')
            ->with('success', 'Fee structure updated successfully.');
    }

    public function destroy(FeeStructure $feeStructure)
    {
        $feeStructure->delete();
        return redirect()->route('admin.finance.fee-structures.index')
            ->with('success', 'Fee structure deleted successfully.');
    }
}