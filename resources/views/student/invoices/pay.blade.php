@extends('layouts.master')
@section('title') Make Payment @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Financial Records @endslot
    @slot('title') Make Payment for Invoice #{{ $invoice->invoice_number }} @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Invoice Amount: TSh {{ number_format($invoice->total_amount, 2) }}</h5>
                            <h6>Balance Due: TSh {{ number_format($invoice->balance, 2) }}</h6>
                        </div>
                    </div>

                    <form action="{{ route('student.invoices.submitPayment', $invoice) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Method</label>
                                <select name="payment_method" class="form-select" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="number" name="amount" class="form-control" 
                                       step="0.01" max="{{ $invoice->balance }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Reference Number</label>
                                <input type="text" name="reference_number" class="form-control" 
                                    value="{{ App\Helpers\ReferenceGenerator::generate() }}" 
                                    readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Proof (Image/PDF)</label>
                                <input type="file" name="payment_proof" class="form-control" 
                                       accept="image/*,.pdf" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                                <a href="{{ route('student.invoices.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection