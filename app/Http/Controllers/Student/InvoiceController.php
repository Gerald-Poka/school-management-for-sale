<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('student_id', auth()->user()->student->id)
            ->latest()
            ->paginate(10);

        return view('student.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Ensure students can only view their own invoices
        if ($invoice->student_id !== auth()->user()->student->id) {
            abort(403, 'Unauthorized access');
        }

        return view('student.invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        // Ensure students can only print their own invoices
        if ($invoice->student_id !== auth()->user()->student->id) {
            abort(403, 'Unauthorized access');
        }

        return view('student.invoices.print', compact('invoice'));
    }

    public function pay(Invoice $invoice)
    {
        return view('student.invoices.pay', compact('invoice'));
    }

    public function submitPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,mobile_money',
            'amount' => 'required|numeric|min:1|max:' . $invoice->balance,
            'reference_number' => 'required|string',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Generate receipt number
        $receiptNumber = 'RCP-' . date('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT);

        // Store the proof file
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Create payment record
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'reference_number' => $request->reference_number,
            'receipt_number' => $receiptNumber,
            'notes' => $request->notes,
            'payment_proof' => $proofPath,
            'status' => 'pending'
        ]);

        return redirect()->route('student.invoices.index')
            ->with('success', 'Payment submitted successfully and awaiting approval.');
    }
}