<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice.student'])
            ->latest()
            ->get();

        return view('admin.finance.payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::with(['invoices' => function($query) {
            $query->whereIn('status', ['pending', 'partially_paid']);
        }])->get();
        
        return view('admin.finance.payments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money',
            'reference_number' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $invoice = Invoice::findOrFail($validated['invoice_id']);
            
            // Create payment
            $payment = Payment::create([
                'invoice_id' => $validated['invoice_id'],
                'amount' => $validated['amount'],
                'payment_date' => $validated['payment_date'],
                'payment_method' => $validated['payment_method'],
                'reference_number' => $validated['reference_number'],
                'notes' => $validated['notes'],
                'receipt_number' => $this->generateReceiptNumber(),
            ]);

            // Update invoice status
            $totalPaid = $invoice->payments->sum('amount') + $validated['amount'];
            $invoice->status = $totalPaid >= $invoice->total_amount ? 'paid' : 'partially_paid';
            $invoice->save();

            DB::commit();
            return redirect()->route('admin.finance.payments.show', $payment)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record payment. Please try again.');
        }
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice.student', 'invoice.items.feeStructure.feeType']);
        return view('admin.finance.payments.show', compact('payment'));
    }

    public function generateReceipt(Payment $payment)
    {
        $payment->load(['invoice.student', 'invoice.items.feeStructure.feeType']);
        return view('admin.finance.payments.receipt', compact('payment'));
    }

    private function generateReceiptNumber()
    {
        $prefix = 'RCP';
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $lastPayment = Payment::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();

        $sequence = $lastPayment ? (intval(substr($lastPayment->receipt_number, -4)) + 1) : 1;
        return $prefix . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function approve(Payment $payment)
    {
        try {
            DB::beginTransaction();

            $payment->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            // Get the invoice and calculate totals
            $invoice = $payment->invoice;
            $totalPaid = $invoice->payments()
                ->where('status', 'approved')
                ->sum('amount');
            
            // Calculate remaining balance
            $remainingBalance = $invoice->total_amount - $totalPaid;

            // Update invoice status based on payment
            if ($totalPaid >= $invoice->total_amount) {
                $invoice->update(['status' => Invoice::STATUS_PAID]);
            } else {
                $invoice->update(['status' => Invoice::STATUS_PARTIAL]);
            }

            $message = sprintf(
                'Payment approved successfully. %s',
                $invoice->status === Invoice::STATUS_PAID 
                    ? 'Invoice has been marked as paid.' 
                    : sprintf('Remaining balance: TSh %s', number_format($remainingBalance, 2))
            );

            DB::commit();

            return response()->json([
                'message' => $message,
                'status' => 'success',
                'remainingBalance' => $remainingBalance
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Error approving payment: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function reject(Request $request, Payment $payment)
    {
        try {
            $request->validate([
                'rejection_reason' => 'required|string|max:500'
            ]);

            $payment->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            return response()->json([
                'message' => 'Payment rejected successfully',
                'status' => 'success'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error rejecting payment: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }
}