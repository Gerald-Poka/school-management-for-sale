@extends('layouts.master')
@section('title') Edit Teacher @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teachers @endslot
    @slot('title') Edit Teacher @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Teacher Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Personal Information (Read Only) -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Personal Information</h5>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" value="{{ $teacher->employee_id }}" readonly>
                                    <small class="text-muted">Cannot be modified</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $teacher->first_name }} {{ $teacher->last_name }}" readonly>
                                    <small class="text-muted">Contact admin to modify</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" value="{{ ucfirst($teacher->gender) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="text" class="form-control" 
                                           value="{{ $teacher->date_of_birth->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information (Editable) -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Contact Information</h5>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone', $teacher->phone) }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Alternative Phone</label>
                                    <input type="tel" name="alternative_phone" 
                                           class="form-control @error('alternative_phone') is-invalid @enderror" 
                                           value="{{ old('alternative_phone', $teacher->alternative_phone) }}">
                                    @error('alternative_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label required">Physical Address</label>
                                    <textarea name="physical_address" class="form-control @error('physical_address') is-invalid @enderror" 
                                              rows="2" required>{{ old('physical_address', $teacher->physical_address) }}</textarea>
                                    @error('physical_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Postal Address</label>
                                    <textarea name="postal_address" class="form-control @error('postal_address') is-invalid @enderror" 
                                              rows="2">{{ old('postal_address', $teacher->postal_address) }}</textarea>
                                    @error('postal_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Updates -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Professional Updates</h5>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Teaching License Number</label>
                                    <input type="text" name="teaching_license_number" 
                                           class="form-control @error('teaching_license_number') is-invalid @enderror" 
                                           value="{{ old('teaching_license_number', $teacher->teaching_license_number) }}">
                                    @error('teaching_license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">License Expiry Date</label>
                                    <input type="date" name="license_expiry_date" 
                                           class="form-control @error('license_expiry_date') is-invalid @enderror" 
                                           value="{{ old('license_expiry_date', $teacher->license_expiry_date?->format('Y-m-d')) }}">
                                    @error('license_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Updates -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Update Documents</h5>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Update Teaching License</label>
                                    <input type="file" name="teaching_license" 
                                           class="form-control @error('teaching_license') is-invalid @enderror">
                                    @if($teacher->teaching_license_path)
                                        <small class="text-muted">Current file exists</small>
                                    @endif
                                    @error('teaching_license')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Update Certificates</label>
                                    <input type="file" name="certificates" 
                                           class="form-control @error('certificates') is-invalid @enderror">
                                    @if($teacher->certificates_path)
                                        <small class="text-muted">Current file exists</small>
                                    @endif
                                    @error('certificates')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_active" class="form-check-input" 
                                           id="is_active" value="1" {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Status</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Information</button>
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