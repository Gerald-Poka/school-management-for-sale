@extends('layouts.master')
@section('title') Invoice Details @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Financial Records @endslot
    @slot('title') Invoice Details @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h5 class="mb-3">Invoice Information:</h5>
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

                    <div class="table-responsive">
                        <table class="table table-bordered">
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
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total Amount:</strong></td>
                                    <td class="text-end"><strong>TSh {{ number_format($invoice->total_amount, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('student.invoices.index') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('student.invoices.print', $invoice) }}" 
                                   class="btn btn-info">
                                    <i class="ri-printer-fill align-bottom me-1"></i> Print Invoice
                                </a>
                            </div>
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