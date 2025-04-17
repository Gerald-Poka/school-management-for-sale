@extends('layouts.master')
@section('title') Invoices @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Invoices @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Invoices List</h4>
                    <div class="float-end">
                        <a href="{{ route('admin.finance.invoices.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Create New Invoice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Student</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->student->full_name }}</td>
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
                                                <a href="{{ route('admin.finance.invoices.show', $invoice) }}" 
                                                   class="btn btn-soft-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="ri-eye-fill"></i>
                                                </a>

                                                {{-- Edit Button (Only for pending invoices) --}}
                                                @if($invoice->status === 'pending')
                                                <a href="{{ route('admin.finance.invoices.edit', $invoice) }}" 
                                                   class="btn btn-soft-warning btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Edit Invoice">
                                                    <i class="ri-pencil-fill"></i>
                                                </a>
                                                @endif

                                                {{-- Print Button --}}
                                                <a href="{{ route('admin.finance.invoices.print', $invoice) }}" 
                                                   class="btn btn-soft-info btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Print Invoice">
                                                    <i class="ri-printer-fill"></i>
                                                </a>

                                                {{-- Send Button --}}
                                                <a href="{{ route('admin.finance.invoices.send', $invoice) }}" 
                                                   class="btn btn-soft-success btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="Send Invoice">
                                                    <i class="ri-mail-send-fill"></i>
                                                </a>

                                                {{-- Delete Button (Only for pending invoices) --}}
                                                @if($invoice->status === 'pending')
                                                <form action="{{ route('admin.finance.invoices.destroy', $invoice) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-soft-danger btn-sm" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Delete Invoice"
                                                            onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No invoices found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $invoices->links() }}
                    </div>
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