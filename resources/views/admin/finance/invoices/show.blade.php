@extends('layouts.master')
@section('title') Invoice Details @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Invoice Details @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h5 class="mb-3">Student Information:</h5>
                            <p class="mb-1">{{ $invoice->student->first_name }} {{ $invoice->student->middle_name }} {{ $invoice->student->last_name }}</p>
                            <p class="mb-1">Admission No: {{ $invoice->student->admission_number }}</p>
                            @if($invoice->student->academicLevel)
                                <p class="mb-1">Class: {{ $invoice->student->academicLevel->name }}</p>
                            @endif
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <h5 class="mb-3">Invoice Details:</h5>
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
                                    <th>Academic Level</th>
                                    <th class="text-end">Amount (TSh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td>{{ $item->feeStructure->feeType->name }}</td>
                                        <td>{{ $item->feeStructure->academicLevel->name }}</td>
                                        <td class="text-end">{{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="text-end"><strong>Total Amount:</strong></td>
                                    <td class="text-end"><strong>TSh {{ number_format($invoice->total_amount, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($invoice->note)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Note:</h5>
                                <p>{{ $invoice->note }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-secondary">Back</a>
                                <a href="{{ route('admin.finance.invoices.print', $invoice) }}" class="btn btn-info">
                                    <i class="ri-printer-fill align-bottom me-1"></i> Print
                                </a>
                                <a href="{{ route('admin.finance.invoices.send', $invoice) }}" class="btn btn-primary">
                                    <i class="ri-mail-send-fill align-bottom me-1"></i> Send
                                </a>
                                @if($invoice->status === 'pending')
                                    <a href="{{ route('admin.finance.invoices.edit', $invoice) }}" class="btn btn-warning">
                                        <i class="ri-pencil-fill align-bottom me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.finance.invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this invoice?')">
                                            <i class="ri-delete-bin-fill align-bottom me-1"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection