@extends('layouts.master')
@section('title') Edit Fee Structure @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Edit Fee Structure @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.finance.fee-structures.update', $feeStructure) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Academic Level</label>
                                <select name="academic_level_id" class="form-select @error('academic_level_id') is-invalid @enderror" required>
                                    <option value="">Select Level</option>
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->id }}" {{ $feeStructure->academic_level_id == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fee Type</label>
                                <select name="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror" required>
                                    <option value="">Select Fee Type</option>
                                    @foreach($feeTypes as $type)
                                        <option value="{{ $type->id }}" {{ $feeStructure->fee_type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fee_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount (TSh)</label>
                                <input type="number" name="amount" value="{{ old('amount', $feeStructure->amount) }}"
                                       class="form-control @error('amount') is-invalid @enderror" 
                                       step="0.01" min="0" max="999999999.99" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Effective From</label>
                                <input type="date" name="effective_from" value="{{ $feeStructure->effective_from->format('Y-m-d') }}"
                                       class="form-control @error('effective_from') is-invalid @enderror" required>
                                @error('effective_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Effective To (Optional)</label>
                                <input type="date" name="effective_to" 
                                       value="{{ $feeStructure->effective_to ? $feeStructure->effective_to->format('Y-m-d') : '' }}"
                                       class="form-control @error('effective_to') is-invalid @enderror">
                                @error('effective_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                           {{ $feeStructure->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Fee Structure</button>
                            <a href="{{ route('admin.finance.fee-structures.index') }}" class="btn btn-secondary">Cancel</a>
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