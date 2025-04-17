<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use Illuminate\Http\Request;
use App\Traits\FeeResponseMessages;

class FeeTypeController extends Controller
{
    use FeeResponseMessages;

    public function index()
    {
        $feeTypes = FeeType::latest()->paginate(10);
        return view('admin.finance.fee-types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('admin.finance.fee-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:fee_types',
            'frequency' => 'required|in:one_time,term,annual',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        try {
            FeeType::create($validated);
            return redirect()->route('admin.finance.fee-types.index')
                           ->with('success', $this->getSuccessMessage('fee type', 'created'));
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', $this->getErrorMessage('fee type', 'create'));
        }
    }

    public function edit(FeeType $feeType)
    {
        return view('admin.finance.fee-types.edit', compact('feeType'));
    }

    public function update(Request $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:fee_types,code,' . $feeType->id,
            'frequency' => 'required|in:one_time,term,annual',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        try {
            $feeType->update($validated);
            return redirect()->route('admin.finance.fee-types.index')
                           ->with('success', $this->getSuccessMessage('fee type', 'updated'));
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', $this->getErrorMessage('fee type', 'update'));
        }
    }

    public function destroy(FeeType $feeType)
    {
        try {
            if ($feeType->feeStructures()->exists()) {
                return back()->with('error', 'Cannot delete fee type that has fee structures.');
            }
            $feeType->delete();
            return redirect()->route('admin.finance.fee-types.index')
                           ->with('success', $this->getSuccessMessage('fee type', 'deleted'));
        } catch (\Exception $e) {
            return back()->with('error', $this->getErrorMessage('fee type', 'delete'));
        }
    }
}