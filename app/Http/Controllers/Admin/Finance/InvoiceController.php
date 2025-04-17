<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Student;
use App\Models\FeeStructure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['student' => function($query) {
            $query->select('id', 'first_name', 'middle_name', 'last_name', 'admission_number');
        }])
        ->latest()
        ->paginate(15);

        return view('admin.finance.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $students = Student::with(['academicLevel'])
            ->where('is_active', true)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
        
        $feeStructures = FeeStructure::with(['feeType', 'academicLevel'])
            ->where('is_active', true)
            ->select('id', 'fee_type_id', 'academic_level_id', 'amount') // Make sure to include amount
            ->get();

        return view('admin.finance.invoices.create', compact('students', 'feeStructures'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.fee_structure_id' => 'required|exists:fee_structures,id',
            'items.*.amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'student_id' => $validated['student_id'],
                'invoice_number' => $this->generateInvoiceNumber(),
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending'
            ]);

            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'fee_structure_id' => $item['fee_structure_id'],
                    'amount' => $item['amount']
                ]);
            }

            DB::commit();
            return redirect()->route('admin.finance.invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create invoice. Please try again.');
        }
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['student', 'items.feeStructure.feeType']);
        return view('admin.finance.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status !== 'pending') {
            return back()->with('error', 'Only pending invoices can be edited.');
        }

        $students = Student::with('academicLevel')->get();
        $feeStructures = FeeStructure::with(['academicLevel', 'feeType'])
            ->where('is_active', true)
            ->get();

        return view('admin.finance.invoices.edit', compact('invoice', 'students', 'feeStructures'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status !== 'pending') {
            return back()->with('error', 'Only pending invoices can be updated.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'items' => 'required|array|min:1',
            'items.*.fee_structure_id' => 'required|exists:fee_structures,id',
            'items.*.amount' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $invoice->update([
                'student_id' => $validated['student_id'],
                'invoice_date' => $validated['invoice_date'],
                'due_date' => $validated['due_date'],
                'note' => $validated['note'] ?? null
            ]);

            // Delete existing items and create new ones
            $invoice->items()->delete();
            foreach ($validated['items'] as $item) {
                $invoice->items()->create([
                    'fee_structure_id' => $item['fee_structure_id'],
                    'amount' => $item['amount']
                ]);
            }

            DB::commit();
            return redirect()->route('admin.finance.invoices.show', $invoice)
                ->with('success', 'Invoice updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update invoice. Please try again.');
        }
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->status !== 'pending') {
            return back()->with('error', 'Only pending invoices can be deleted.');
        }

        DB::beginTransaction();
        try {
            $invoice->items()->delete();
            $invoice->delete();
            DB::commit();
            return redirect()->route('admin.finance.invoices.index')
                ->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete invoice. Please try again.');
        }
    }

    private function generateInvoiceNumber()
    {
        $prefix = 'INV';
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $lastInvoice = Invoice::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();

        $sequence = $lastInvoice ? (intval(substr($lastInvoice->invoice_number, -4)) + 1) : 1;
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['student', 'items.feeStructure.feeType']);
        return view('admin.finance.invoices.print', compact('invoice'));
    }

    public function send(Invoice $invoice)
    {
        // Email invoice implementation will go here
        return back()->with('success', 'Invoice sent successfully.');
    }
}