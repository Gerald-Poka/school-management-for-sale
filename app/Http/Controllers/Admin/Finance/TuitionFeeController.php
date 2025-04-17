<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\AcademicLevel;
use App\Models\FeeType;
use Illuminate\Http\Request;
use App\Traits\FeeResponseMessages;

class TuitionFeeController extends Controller
{
    use FeeResponseMessages;

    public function index()
    {
        $tuitionFees = FeeStructure::with(['academicLevel', 'feeType'])
            ->whereHas('feeType', function($query) {
                $query->where('code', 'TUT');
            })
            ->orderBy('academic_level_id')
            ->get();

        return view('admin.finance.tuition-fees.index', compact('tuitionFees'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        return view('admin.finance.tuition-fees.create', compact('academicLevels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'amount' => 'required|numeric|min:1000000|max:2800000',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'boolean'
        ]);

        try {
            $feeType = FeeType::firstOrCreate(
                ['code' => 'TUT'],
                [
                    'name' => 'Tuition Fee',
                    'frequency' => 'term',
                    'description' => 'Regular tuition fee charged per term',
                    'is_active' => true
                ]
            );

            $validated['fee_type_id'] = $feeType->id;
            FeeStructure::create($validated);

            return redirect()->route('admin.finance.tuition-fees.index')
                ->with('success', $this->getSuccessMessage('tuition', 'created'));
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $this->getErrorMessage('tuition', 'create'));
        }
    }

    public function edit(FeeStructure $tuitionFee)
    {
        return view('admin.finance.tuition-fees.edit', compact('tuitionFee'));
    }

    public function update(Request $request, FeeStructure $tuitionFee)
    {
        $validated = $request->validate([
            'academic_level_id' => 'required|exists:academic_levels,id',
            'amount' => 'required|numeric|min:1000000|max:2800000',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after:effective_from',
            'is_active' => 'boolean'
        ]);

        $tuitionFee->update($validated);

        return redirect()->route('admin.finance.tuition-fees.index')
            ->with('success', 'Tuition fee structure updated successfully.');
    }

    public function destroy(FeeStructure $tuitionFee)
    {
        $tuitionFee->delete();
        return redirect()->route('admin.finance.tuition-fees.index')
            ->with('success', 'Tuition fee structure deleted successfully.');
    }
}