<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeCollection;
use App\Models\Student;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeCollectionController extends Controller
{
    public function index()
    {
        $collections = FeeCollection::with(['student', 'feeStructure'])
            ->latest()
            ->paginate(15);

        $totalCollected = FeeCollection::sum('amount_paid');
        $pendingCollections = FeeCollection::where('status', 'pending')->count();

        return view('admin.finance.fee-collection.index', compact('collections', 'totalCollected', 'pendingCollections'));
    }

    public function create()
    {
        $students = Student::with('academicLevel')->get();
        $feeStructures = FeeStructure::with(['academicLevel', 'feeType'])->where('is_active', true)->get();
        
        return view('admin.finance.fee-collection.create', compact('students', 'feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_structure_id' => 'required|exists:fee_structures,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money',
            'payment_date' => 'required|date',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500'
        ]);

        $validated['status'] = 'completed';
        FeeCollection::create($validated);

        return redirect()->route('admin.finance.fee-collection')
            ->with('success', 'Fee collection recorded successfully.');
    }
}