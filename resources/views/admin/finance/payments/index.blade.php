@extends('layouts.master')
@section('title') Payment Management @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Payment Management @endslot
@endcomponent

<div class="container-fluid">
    <!-- Alert Message Section -->
    <div id="alertMessage" style="display: none;" class="alert alert-dismissible fade show" role="alert">
        <span id="alertText"></span>
        <button type="button" class="btn-close" onclick="closeAlert()"></button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Student</th>
                                    <th>Invoice #</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Actions</th>
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
                                        <td>TSh {{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>{{ $payment->reference_number }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->status === 'approved' ? 'success' : 
                                                ($payment->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if($payment->payment_proof)
                                                    <a href="{{ Storage::url($payment->payment_proof) }}" 
                                                       target="_blank"
                                                       class="btn btn-soft-info btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="View Proof">
                                                        <i class="ri-eye-fill"></i>
                                                    </a>
                                                @endif

                                                @if($payment->status === 'pending')
                                                    <button type="button"
                                                            class="btn btn-soft-success btn-sm approve-payment"
                                                            data-payment-id="{{ $payment->id }}"
                                                            data-bs-toggle="tooltip"
                                                            title="Approve Payment">
                                                        <i class="ri-check-fill"></i>
                                                    </button>
                                                    
                                                    <button type="button"
                                                            class="btn btn-soft-danger btn-sm reject-payment"
                                                            data-payment-id="{{ $payment->id }}"
                                                            data-bs-toggle="tooltip"
                                                            title="Reject Payment">
                                                        <i class="ri-close-fill"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No payments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Payments Section that have been approved -->
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0">Total Approved Payments</p>
                            <h4 class="fs-22 fw-semibold mb-0">
                                TSh {{ number_format($payments->where('status', 'approved')->sum('amount'), 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-soft-success flex-shrink-0">
                            <span class="avatar-title rounded-circle bg-soft-success text-success">
                                <i class="ri-money-dollar-circle-fill fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0">Pending Payments</p>
                            <h4 class="fs-22 fw-semibold mb-0">
                                TSh {{ number_format($payments->where('status', 'pending')->sum('amount'), 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-soft-warning flex-shrink-0">
                            <span class="avatar-title rounded-circle bg-soft-warning text-warning">
                                <i class="ri-time-fill fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0">Rejected Payments</p>
                            <h4 class="fs-22 fw-semibold mb-0">
                                TSh {{ number_format($payments->where('status', 'rejected')->sum('amount'), 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-soft-danger flex-shrink-0">
                            <span class="avatar-title rounded-circle bg-soft-danger text-danger">
                                <i class="ri-close-circle-fill fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0">Total Payments</p>
                            <h4 class="fs-22 fw-semibold mb-0">
                                TSh {{ number_format($payments->sum('amount'), 2) }}
                            </h4>
                        </div>
                        <div class="avatar-sm rounded-circle bg-soft-primary flex-shrink-0">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                <i class="ri-funds-fill fs-3"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div class="modal fade" id="rejectPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectPaymentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Reason</label>
                        <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
function showAlert(message, type) {
    const alertDiv = document.getElementById('alertMessage');
    const alertText = document.getElementById('alertText');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertText.textContent = message;
    alertDiv.style.display = 'block';
    
    // Scroll to top to show the message
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function closeAlert() {
    document.getElementById('alertMessage').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    // Approve payment
    document.querySelectorAll('.approve-payment').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to approve this payment?')) {
                const paymentId = this.dataset.paymentId;
                fetch(`/admin/finance/payments/${paymentId}/approve`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showAlert(data.message, 'success');
                        
                        // Add a class to highlight the remaining balance if any
                        const statusClass = data.remainingBalance > 0 ? 'warning' : 'success';
                        const row = this.closest('tr');
                        row.querySelector('.badge').className = `badge bg-${statusClass}`;
                        
                        // Reload after showing message
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000); // Increased to 3 seconds to ensure message is readable
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    showAlert('An error occurred while processing your request.', 'danger');
                });
            }
        });
    });

    // Reject payment modal handling
    const rejectForm = document.getElementById('rejectPaymentForm');
    const rejectModal = new bootstrap.Modal(document.getElementById('rejectPaymentModal'));

    rejectForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const paymentId = this.action.split('/').pop();

        fetch(this.action, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                rejection_reason: formData.get('rejection_reason')
            })
        })
        .then(response => response.json())
        .then(data => {
            rejectModal.hide();
            if (data.status === 'success') {
                showAlert(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                showAlert(data.message, 'danger');
            }
        })
        .catch(error => {
            rejectModal.hide();
            showAlert('An error occurred while processing your request.', 'danger');
        });
    });

    document.querySelectorAll('.reject-payment').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.dataset.paymentId;
            const form = document.getElementById('rejectPaymentForm');
            form.action = `/admin/finance/payments/${paymentId}/reject`;
            rejectModal.show();
        });
    });
});
</script>
@endsection