@extends('layouts.master')
@section('title') Edit Fee Type @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Edit Fee Type @endslot
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

                    <form action="{{ route('admin.finance.fee-types.update', $feeType) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Fee Type Name</label>
                                <input type="text" name="name" value="{{ old('name', $feeType->name) }}" 
                                       class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fee Type Code</label>
                                <input type="text" name="code" value="{{ old('code', $feeType->code) }}" 
                                       class="form-control @error('code') is-invalid @enderror" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Frequency</label>
                                <select name="frequency" class="form-select @error('frequency') is-invalid @enderror" required>
                                    <option value="">Select Frequency</option>
                                    <option value="annual" {{ $feeType->frequency === 'annual' ? 'selected' : '' }}>Annual</option>
                                    <option value="term" {{ $feeType->frequency === 'term' ? 'selected' : '' }}>Term</option>
                                    <option value="monthly" {{ $feeType->frequency === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                                @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check mt-2">
                                    <input type="checkbox" name="is_mandatory" value="1" 
                                           class="form-check-input" {{ $feeType->is_mandatory ? 'checked' : '' }}>
                                    <label class="form-check-label">Is Mandatory</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="3">{{ old('description', $feeType->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Fee Type</button>
                            <a href="{{ route('admin.finance.fee-types.index') }}" class="btn btn-secondary">Cancel</a>
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