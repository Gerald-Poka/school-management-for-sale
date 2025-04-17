@extends('layouts.master')
@section('title') Create Other Fee @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Create Other Fee @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Add New Fee</h4>
                </div>
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

                    <form action="{{ route('admin.finance.other-fees.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fee Type</label>
                                <select name="fee_type_id" class="form-select @error('fee_type_id') is-invalid @enderror" required>
                                    <option value="">Select Fee Type</option>
                                    @foreach($feeTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('fee_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }} ({{ ucfirst($type->frequency) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('fee_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Academic Level</label>
                                <select name="academic_level_id" class="form-select @error('academic_level_id') is-invalid @enderror" required>
                                    <option value="">Select Academic Level</option>
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->id }}" {{ old('academic_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Amount (TSh)</label>
                                <input type="number" name="amount" value="{{ old('amount') }}" 
                                       class="form-control @error('amount') is-invalid @enderror"
                                       min="0" step="1000" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="1">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Effective From</label>
                                <input type="date" name="effective_from" value="{{ old('effective_from') }}"
                                       class="form-control @error('effective_from') is-invalid @enderror" required>
                                @error('effective_from')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Effective To (Optional)</label>
                                <input type="date" name="effective_to" value="{{ old('effective_to') }}"
                                       class="form-control @error('effective_to') is-invalid @enderror">
                                @error('effective_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" 
                                       class="form-check-input" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Fee</button>
                            <a href="{{ route('admin.finance.other-fees') }}" class="btn btn-secondary">Cancel</a>
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