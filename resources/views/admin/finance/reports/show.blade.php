@extends('layouts.master')
@section('title') {{ $title }} @endsection

@section('css')
<style>
    .report-header {
        border-bottom: 2px solid #dee2e6;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
    }
    .company-logo {
        max-height: 80px;
        margin-bottom: 1rem;
    }
    .report-info {
        margin-bottom: 2rem;
    }
    .report-meta {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .financial-summary {
        background: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    .summary-item {
        border-bottom: 1px dashed #dee2e6;
        padding: 0.5rem 0;
    }
    .summary-item:last-child {
        border-bottom: none;
    }
    .amount-cell {
        font-family: monospace;
        text-align: right;
    }
    .table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
    @media print {
        .navbar-menu, .app-menu, .footer, .btn { display: none !important; }
        .page-content { padding: 0 !important; margin: 0 !important; }
        .card { box-shadow: none !important; border: none !important; }
        .report-header { border-bottom-color: #000 !important; }
        .financial-summary { border: 1px solid #dee2e6 !important; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Report Header -->
                    <div class="report-header d-flex justify-content-between align-items-start">
                        <div>
                            <img src="{{ asset('school/logo.png') }}" alt="School Logo" class="company-logo">
                            <h4 class="mb-1">Your School Name</h4>
                            <div class="report-meta">
                                P.O. Box 123456<br>
                                Dar es Salaam, Tanzania<br>
                                Phone: +255 673 128 464<br>
                            </div>
                        </div>
                        <div class="text-end">
                            <h2 class="mb-1">{{ $title }}</h2>
                            <div class="report-meta">
                                Report Generated: {{ now()->format('d/m/Y H:i') }}<br>
                                Period: {{ date('d/m/Y', strtotime($dateFrom)) }} to {{ date('d/m/Y', strtotime($dateTo)) }}<br>
                                Academic Level: {{ $academicLevel }}
                            </div>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="financial-summary">
                        <h5 class="mb-3">Financial Summary</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="text-muted">Total Amount</div>
                                    <div class="h5">TSh {{ number_format($totalAmount, 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="text-muted">Approved Payments</div>
                                    <div class="h5 text-success">TSh {{ number_format($summary['approved'], 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="text-muted">Pending Payments</div>
                                    <div class="h5 text-warning">TSh {{ number_format($summary['pending'], 2) }}</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="summary-item">
                                    <div class="text-muted">Rejected Payments</div>
                                    <div class="h5 text-danger">TSh {{ number_format($summary['rejected'], 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Invoice #</th>
                                    <th class="text-end">Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $payment->invoice->student->full_name }}
                                            <small class="d-block text-muted">
                                                {{ $payment->invoice->student->registration_number }}
                                            </small>
                                        </td>
                                        <td>{{ $payment->invoice->invoice_number }}</td>
                                        <td class="amount-cell">{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status === 'approved' ? 'success' : 
                                                ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No payments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Print Button -->
                    <div class="text-end mt-4">
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="ri-printer-fill me-1"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection