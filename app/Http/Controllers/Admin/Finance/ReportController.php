<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AcademicLevel;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        return view('admin.finance.reports.index', compact('academicLevels'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:approved_payments,pending_payments,rejected_payments,payment_summary',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'academic_level_id' => 'nullable|exists:academic_levels,id'
        ]);

        $query = Payment::with(['invoice.student'])
            ->whereBetween('payment_date', [$request->date_from, $request->date_to]);

        if ($request->academic_level_id) {
            $query->whereHas('invoice.student', function($q) use ($request) {
                $q->where('academic_level_id', $request->academic_level_id);
            });
        }

        switch ($request->report_type) {
            case 'approved_payments':
                $payments = $query->where('status', 'approved')->get();
                $title = 'Approved Payments Report';
                break;
            
            case 'pending_payments':
                $payments = $query->where('status', 'pending')->get();
                $title = 'Pending Payments Report';
                break;
            
            case 'rejected_payments':
                $payments = $query->where('status', 'rejected')->get();
                $title = 'Rejected Payments Report';
                break;
            
            case 'payment_summary':
                $payments = $query->get();
                $title = 'Payment Summary Report';
                break;
        }

        $data = [
            'title' => $title,
            'payments' => $payments,
            'dateFrom' => $request->date_from,
            'dateTo' => $request->date_to,
            'academicLevel' => $request->academic_level_id ? 
                AcademicLevel::find($request->academic_level_id)->name : 'All Levels',
            'totalAmount' => $payments->sum('amount'),
            'summary' => [
                'approved' => $payments->where('status', 'approved')->sum('amount'),
                'pending' => $payments->where('status', 'pending')->sum('amount'),
                'rejected' => $payments->where('status', 'rejected')->sum('amount')
            ]
        ];

        // Instead of PDF, return view with data
        return view('admin.finance.reports.show', $data);
    }
}