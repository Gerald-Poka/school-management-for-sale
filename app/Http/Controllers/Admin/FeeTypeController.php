<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::orderBy('name')->get();
        return view('admin.finance.fee-types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('admin.finance.fee-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:fee_types',
            'code' => 'required|string|max:10|unique:fee_types',
            'description' => 'nullable|string',
            'is_mandatory' => 'required|boolean',
            'frequency' => 'required|in:annual,term,monthly'
        ]);

        FeeType::create($validated);

        return redirect()->route('admin.finance.fee-types.index')
            ->with('success', 'Fee type created successfully.');
    }

    public function edit(FeeType $feeType)
    {
        return view('admin.finance.fee-types.edit', compact('feeType'));
    }

    public function update(Request $request, FeeType $feeType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:fee_types,name,' . $feeType->id,
            'code' => 'required|string|max:10|unique:fee_types,code,' . $feeType->id,
            'description' => 'nullable|string',
            'is_mandatory' => 'required|boolean',
            'frequency' => 'required|in:annual,term,monthly'
        ]);

        $feeType->update($validated);

        return redirect()->route('admin.finance.fee-types.index')
            ->with('success', 'Fee type updated successfully.');
    }

    public function destroy(FeeType $feeType)
    {
        $feeType->delete();
        return redirect()->route('admin.finance.fee-types.index')
            ->with('success', 'Fee type deleted successfully.');
    }
}