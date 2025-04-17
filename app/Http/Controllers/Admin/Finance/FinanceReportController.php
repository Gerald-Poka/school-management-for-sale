<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeCollection;
use App\Models\FeeStructure;
use App\Models\Student;
use App\Models\AcademicLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceReportController extends Controller
{
    public function index()
    {
        $academicLevels = AcademicLevel::all();
        return view('admin.finance.reports.index', compact('academicLevels'));
    }

    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:collection,outstanding,summary',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'academic_level_id' => 'nullable|exists:academic_levels,id'
        ]);

        $dateFrom = Carbon::parse($validated['date_from']);
        $dateTo = Carbon::parse($validated['date_to']);

        switch ($validated['report_type']) {
            case 'collection':
                return $this->collectionReport($dateFrom, $dateTo, $validated['academic_level_id']);
            case 'outstanding':
                return $this->outstandingReport($dateFrom, $dateTo, $validated['academic_level_id']);
            case 'summary':
                return $this->summaryReport($dateFrom, $dateTo, $validated['academic_level_id']);
        }
    }

    private function collectionReport($dateFrom, $dateTo, $academicLevelId = null)
    {
        $query = FeeCollection::with(['student.academicLevel', 'feeStructure.feeType'])
            ->whereBetween('payment_date', [$dateFrom, $dateTo])
            ->where('status', 'completed');

        if ($academicLevelId) {
            $query->whereHas('student', function($q) use ($academicLevelId) {
                $q->where('academic_level_id', $academicLevelId);
            });
        }

        $collections = $query->get();

        $summary = [
            'total_collected' => $collections->sum('amount_paid'),
            'collection_by_method' => $collections->groupBy('payment_method')
                ->map(fn($group) => $group->sum('amount_paid')),
            'collection_by_type' => $collections->groupBy('feeStructure.feeType.name')
                ->map(fn($group) => $group->sum('amount_paid'))
        ];

        return view('admin.finance.reports.collection', compact('collections', 'summary', 'dateFrom', 'dateTo'));
    }

    private function outstandingReport($dateFrom, $dateTo, $academicLevelId = null)
    {
        $query = Student::with(['academicLevel', 'feeCollections']);

        if ($academicLevelId) {
            $query->where('academic_level_id', $academicLevelId);
        }

        $students = $query->get();

        $outstandingFees = $students->map(function($student) {
            $totalFees = FeeStructure::where('academic_level_id', $student->academic_level_id)
                ->where('is_active', true)
                ->sum('amount');
            
            $paidFees = $student->feeCollections()
                ->where('status', 'completed')
                ->sum('amount_paid');

            return [
                'student' => $student,
                'total_fees' => $totalFees,
                'paid_fees' => $paidFees,
                'outstanding' => $totalFees - $paidFees
            ];
        })->filter(fn($item) => $item['outstanding'] > 0);

        return view('admin.finance.reports.outstanding', compact('outstandingFees', 'dateFrom', 'dateTo'));
    }

    private function summaryReport($dateFrom, $dateTo, $academicLevelId = null)
    {
        $query = DB::table('fee_collections')
            ->join('fee_structures', 'fee_collections.fee_structure_id', '=', 'fee_structures.id')
            ->join('fee_types', 'fee_structures.fee_type_id', '=', 'fee_types.id')
            ->join('students', 'fee_collections.student_id', '=', 'students.id')
            ->join('academic_levels', 'students.academic_level_id', '=', 'academic_levels.id')
            ->whereBetween('fee_collections.payment_date', [$dateFrom, $dateTo])
            ->where('fee_collections.status', 'completed');

        if ($academicLevelId) {
            $query->where('academic_levels.id', $academicLevelId);
        }

        $summary = [
            'total_collection' => $query->sum('fee_collections.amount_paid'),
            'by_fee_type' => $query->select('fee_types.name', DB::raw('SUM(fee_collections.amount_paid) as total'))
                ->groupBy('fee_types.name')
                ->get(),
            'by_academic_level' => $query->select('academic_levels.name', DB::raw('SUM(fee_collections.amount_paid) as total'))
                ->groupBy('academic_levels.name')
                ->get(),
            'by_payment_method' => $query->select('fee_collections.payment_method', DB::raw('SUM(fee_collections.amount_paid) as total'))
                ->groupBy('fee_collections.payment_method')
                ->get()
        ];

        return view('admin.finance.reports.summary', compact('summary', 'dateFrom', 'dateTo'));
    }

    public function exportReport(Request $request)
    {
        // Implementation for exporting reports to Excel/PDF will go here
        // This can be implemented using Laravel Excel or DomPDF packages
    }
}