@extends('layouts.master')
@section('title') My Invoices @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Financial Records @endslot
    @slot('title') My Invoices @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                                        <td>{{ $invoice->due_date->format('d/m/Y') }}</td>
                                        <td>TSh {{ number_format($invoice->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 
                                                ($invoice->status === 'partially_paid' ? 'warning' : 
                                                ($invoice->status === 'overdue' ? 'danger' : 'info')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                {{-- View Button --}}
                                                <a href="{{ route('student.invoices.show', $invoice) }}" 
                                                   class="btn btn-soft-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="ri-eye-fill"></i>
                                                </a>

                                                {{-- Print Button --}}
                                                <a href="{{ route('student.invoices.print', $invoice) }}" 
                                                   class="btn btn-soft-info btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Print Invoice">
                                                    <i class="ri-printer-fill"></i>
                                                </a>

                                                {{-- Payment Button (Only show for unpaid or partially paid invoices) --}}
                                                @if($invoice->status !== 'paid')
                                                <a href="{{ route('student.invoices.pay', $invoice) }}" 
                                                   class="btn btn-soft-success btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Make Payment">
                                                    <i class="ri-bank-card-fill"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No invoices found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection