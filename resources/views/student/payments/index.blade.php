@extends('layouts.master')
@section('title') My Payments @endsection
@section('css')
<style>
    .payment-card {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        color: white;
        border-radius: 15px;
        padding: 30px;  /* Increased padding */
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
        min-height: 250px;  /* Set minimum height */
    }
    .payment-card:hover {
        transform: translateY(-5px);
    }
    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
    }
    .invoice-group, .reference-group {
        display: flex;
        align-items: center;
        gap: 10px;  /* Space between elements */
    }
    .amount-section {
        margin: 20px 0;
        padding: 10px 0;
    }
    .payment-amount {
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 1px;
        margin: 0; /* Remove existing margins */
    }
    .payment-details {
        font-size: 14px;
        opacity: 0.9;
        margin-top: 20px;  /* Added margin top */
    }
    .payment-details .row {
        margin: 0 -10px;  /* Adjust row margins */
    }
    .payment-details .col-6 {
        padding: 0 10px;  /* Adjust column padding */
    }
    .payment-status .badge {
        font-size: 11px;
        padding: 4px 8px;
        border-radius: 12px;
    }
    .proof-link {
        font-size: 12px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        background: rgba(255,255,255,0.1);
        padding: 6px 12px;
        border-radius: 12px;
        transition: all 0.3s ease;
        align-self: center;
        white-space: nowrap;
    }
    .proof-link:hover {
        background: rgba(255,255,255,0.2);
        color: white;
    }
    /* Adjust grid column sizes */
    @media (min-width: 768px) {
        .col-md-6 {
            flex: 0 0 auto;
            width: 100%;  /* Full width on medium screens */
        }
    }
    @media (min-width: 992px) {
        .col-lg-4 {
            flex: 0 0 auto;
            width: 50%;  /* Two columns on large screens */
        }
    }
    @media (min-width: 1200px) {
        .col-lg-4 {
            width: 50%;  /* Maintain two columns on extra large screens */
        }
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Financial Records @endslot
    @slot('title') My Payments @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        @forelse($payments as $payment)
            <div class="col-md-6 col-lg-4">
                <div class="payment-card">
                    <div class="payment-header">
                        <div>
                            <small class="d-block text-white-50">Payment Date</small>
                            <strong>{{ $payment->payment_date->format('d/m/Y') }}</strong>
                        </div>
                        <div class="invoice-group">
                            <div>
                                <small class="d-block text-white-50">Invoice Number</small>
                                <strong>{{ $payment->invoice->invoice_number }}</strong>
                            </div>
                            <div class="payment-status">
                                <span class="badge bg-{{ $payment->status === 'approved' ? 'success' : 
                                    ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="amount-section d-flex justify-content-between align-items-center">
                        <div class="payment-amount">
                            TSh {{ number_format($payment->amount, 2) }}
                        </div>
                        @if($payment->payment_proof)
                            <a href="{{ Storage::url($payment->payment_proof) }}" 
                               target="_blank" 
                               class="proof-link">
                                <i class="ri-eye-fill"></i> Proof
                            </a>
                        @endif
                    </div>

                    <div class="payment-details">
                        <div class="row mb-2">
                            <div class="col-6">
                                <small class="d-block text-white-50">Payment Method</small>
                                {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </div>
                            <div class="col-6">
                                <div class="reference-group">
                                    <div>
                                        <small class="d-block text-white-50">Reference</small>
                                        {{ $payment->reference_number }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="text-muted">No payments found</h5>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection