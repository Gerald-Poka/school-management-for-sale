<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\AcademicLevel;
use App\Models\FeeType;
use Illuminate\Http\Request;
use App\Traits\FeeResponseMessages;

class TransportFeeController extends Controller
{
    use FeeResponseMessages;

    public function index()
    {
        $transportFees = FeeStructure::with(['academicLevel', 'feeType'])
            ->whereHas('feeType', function($query) {
                $query->where('code', 'TRANS');
            })
            ->orderBy('academic_level_id')
            ->get();

        return view('admin.finance.transport-fees.index', compact('transportFees'));
    }

    public function create()
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        return view('admin.finance.transport-fees.create', compact('academicLevels'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'academic_level_id' => 'required|exists:academic_levels,id',
                'route_name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'effective_from' => 'required|date',
                'effective_to' => 'nullable|date|after:effective_from',
                'is_active' => 'required|boolean'
            ]);

            $feeType = FeeType::firstOrCreate(
                ['code' => 'TRANS'],
                [
                    'name' => 'Transport Fee',
                    'frequency' => 'term',
                    'description' => 'School transport service fee',
                    'is_active' => true
                ]
            );

            $validated['fee_type_id'] = $feeType->id;
            FeeStructure::create($validated);

            return redirect()->route('admin.finance.transport-fees.index')
                ->with('success', $this->getSuccessMessage('transport', 'created'));
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $this->getErrorMessage('transport', 'create'));
        }
    }

    public function edit(FeeStructure $transportFee)
    {
        $academicLevels = AcademicLevel::orderBy('name')->get();
        return view('admin.finance.transport-fees.edit', compact('transportFee', 'academicLevels'));
    }

    public function update(Request $request, FeeStructure $transportFee)
    {
        try {
            $validated = $request->validate([
                'academic_level_id' => 'required|exists:academic_levels,id',
                'route_name' => 'required|string|max:255',
                'amount' => 'required|numeric|min:0',
                'effective_from' => 'required|date',
                'effective_to' => 'nullable|date|after:effective_from',
                'is_active' => 'required|boolean'
            ]);

            $transportFee->update($validated);

            return redirect()->route('admin.finance.transport-fees.index')
                ->with('success', $this->getSuccessMessage('transport', 'updated'));
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', $this->getErrorMessage('transport', 'update'));
        }
    }

    public function destroy(FeeStructure $transportFee)
    {
        try {
            $transportFee->delete();
            return redirect()->route('admin.finance.transport-fees.index')
                ->with('success', $this->getSuccessMessage('transport', 'deleted'));
        } catch (\Exception $e) {
            return back()->with('error', $this->getErrorMessage('transport', 'delete'));
        }
    }
}