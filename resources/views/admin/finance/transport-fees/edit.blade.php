@extends('layouts.master')
@section('title') Edit Transport Fee @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Edit Transport Fee @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Transport Fee Structure</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.transport-fees.update', $transportFee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label required">Route/Zone Name</label>
                            <input type="text" 
                                   name="route_name" 
                                   class="form-control @error('route_name') is-invalid @enderror"
                                   value="{{ old('route_name', $transportFee->route_name) }}"
                                   required>
                            @error('route_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Academic Level</label>
                            <input type="text" class="form-control" value="{{ $transportFee->academicLevel->name }}" disabled>
                            <input type="hidden" name="academic_level_id" value="{{ $transportFee->academic_level_id }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Amount (TSh)</label>
                            <input type="number" 
                                   name="amount" 
                                   class="form-control @error('amount') is-invalid @enderror"
                                   value="{{ old('amount', $transportFee->amount) }}"
                                   min="0"
                                   required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Effective From</label>
                            <input type="date" 
                                   name="effective_from" 
                                   class="form-control @error('effective_from') is-invalid @enderror"
                                   value="{{ old('effective_from', $transportFee->effective_from->format('Y-m-d')) }}"
                                   required>
                            @error('effective_from')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Effective To</label>
                            <input type="date" 
                                   name="effective_to" 
                                   class="form-control @error('effective_to') is-invalid @enderror"
                                   value="{{ old('effective_to', $transportFee->effective_to?->format('Y-m-d')) }}">
                            @error('effective_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty for ongoing fee structure</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       name="is_active" 
                                       id="is_active"
                                       value="1"
                                       {{ $transportFee->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.finance.transport-fees.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Fee Structure</button>
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