@extends('layouts.master')
@section('title') Financial Reports @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Financial Reports @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Generate Financial Report</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.reports.generate') }}" method="POST" id="reportForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Report Type</label>
                                <select name="report_type" class="form-select @error('report_type') is-invalid @enderror" required>
                                    <option value="">Select Report Type</option>
                                    <option value="approved_payments">Approved Payments Report</option>
                                    <option value="pending_payments">Pending Payments Report</option>
                                    <option value="rejected_payments">Rejected Payments Report</option>
                                    <option value="payment_summary">Payment Summary Report</option>
                                </select>
                                @error('report_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Academic Level (Optional)</label>
                                <select name="academic_level_id" class="form-select @error('academic_level_id') is-invalid @enderror">
                                    <option value="">All Levels</option>
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Date From</label>
                                <input type="date" name="date_from" class="form-control @error('date_from') is-invalid @enderror" required>
                                @error('date_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Date To</label>
                                <input type="date" name="date_to" class="form-control @error('date_to') is-invalid @enderror" required>
                                @error('date_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Generate Report</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateFrom = document.querySelector('input[name="date_from"]');
    const dateTo = document.querySelector('input[name="date_to"]');

    dateFrom.addEventListener('change', function() {
        dateTo.min = this.value;
    });

    dateTo.addEventListener('change', function() {
        dateFrom.max = this.value;
    });
});
</script>
@endsection