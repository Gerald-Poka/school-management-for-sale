@extends('layouts.master')
@section('title') Print Invoice @endsection

@section('css')
<style>
    .invoice-page {
        background: #fff;
        padding: 20px;
    }
    
    .invoice-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 30px;
        background: #fff;
    }
    
    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #405189;
        padding-bottom: 20px;
    }
    
    .school-logo {
        max-width: 120px;
        height: auto;
        margin-bottom: 15px;
    }
    
    .school-info {
        margin-bottom: 20px;
        color: #000; /* Make text black */
    }
    
    .school-info h3 {
        color: #000; /* Change from #405189 to black */
        font-size: 24px;
        margin-bottom: 5px;
    }
    
    .invoice-title {
        font-size: 28px;
        color: #000; /* Change from #0ab39c to black */
        margin: 15px 0;
        font-weight: 600;
    }
    
    .bill-info {
        margin-bottom: 30px;
        color: #000; /* Make text black */
    }
    
    .bill-info .label {
        color: #000; /* Change from #405189 to black */
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }
    
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    
    .items-table th {
        background: #405189;
        color: #fff;
        padding: 12px 15px;
        text-align: left;
    }
    
    .items-table td {
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        color: #000; /* Make text black */
    }
    
    .items-table tr:nth-child(even) {
        background: #f8f9fa;
    }
    
    .total-row {
        background: #f1f5f9 !important;
        font-weight: 600;
    }
    
    .invoice-footer {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
        text-align: center;
    }
    
    .payment-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: #000; /* Make text black */
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-wrapper,
        .invoice-wrapper * {
            visibility: visible;
        }
        .invoice-wrapper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
        .page-content {
            padding: 0 !important;
            margin: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Financial Records @endslot
    @slot('title') Print Invoice @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body invoice-page p-4">
                    <div class="invoice-wrapper">
                        <!-- Header Section -->
                        <div class="invoice-header">
                            <img src="{{ asset('school/logo.png') }}" alt="School Logo" class="school-logo">
                            <div class="school-info">
                                <h3>{{ config('app.name') }}</h3>
                                <p class="mb-1">P.O Box 123, City Name</p>
                                <p class="mb-1">Phone: +255 673 128 464</p>
                                <p>Email: geraldndyamukama39@gmail.com</p>
                            </div>
                            <div class="invoice-title">INVOICE</div>
                        </div>

                        <!-- Bill Info Section -->
                        <div class="row bill-info">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label">BILL TO:</span>
                                    <h5 class="mb-1">{{ $invoice->student->first_name }} {{ $invoice->student->last_name }}</h5>
                                    <p class="mb-1">Admission No: {{ $invoice->student->admission_number }}</p>
                                    <p>Class: {{ $invoice->student->academicLevel->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="mb-4">
                                    <span class="label">INVOICE DETAILS:</span>
                                    <p class="mb-1">Invoice #: {{ $invoice->invoice_number }}</p>
                                    <p class="mb-1">Date: {{ $invoice->invoice_date->format('d/m/Y') }}</p>
                                    <p class="mb-1">Due Date: {{ $invoice->due_date->format('d/m/Y') }}</p>
                                    <p class="mb-1">Status: 
                                        <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 
                                            ($invoice->status === 'partially_paid' ? 'warning' : 
                                            ($invoice->status === 'overdue' ? 'danger' : 'info')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="table-responsive">
                            <table class="items-table">
                                <thead>
                                    <tr>
                                        <th>Fee Type</th>
                                        <th>Description</th>
                                        <th class="text-end">Amount (TSh)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->feeStructure->feeType->name }}</td>
                                        <td>{{ $item->feeStructure->description ?? '-' }}</td>
                                        <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="total-row">
                                        <td colspan="2" class="text-end">Total Amount:</td>
                                        <td class="text-end">TSh {{ number_format($invoice->total_amount, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Payment Info -->
                        <div class="payment-info">
                            <h5 class="mb-3">Payment Information</h5>
                            <p class="mb-1">Bank Name: ABC Bank</p>
                            <p class="mb-1">Account Name: School Name</p>
                            <p class="mb-0">Account Number: 1234567890</p>
                        </div>

                        <!-- Footer -->
                        <div class="invoice-footer">
                            <p class="mb-0">This is a computer-generated document and requires no signature.</p>
                        </div>

                        <!-- Print Buttons -->
                        <div class="text-center mt-4 no-print">
                            <button onclick="window.print()" class="btn btn-primary waves-effect waves-light me-1">
                                <i class="ri-printer-line align-middle me-1"></i> Print Invoice
                            </button>
                            <button onclick="window.history.back()" class="btn btn-secondary waves-effect waves-light">
                                <i class="ri-arrow-left-line align-middle me-1"></i> Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection