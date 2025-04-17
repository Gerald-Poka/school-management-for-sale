@extends('layouts.master')
@section('title') Teacher Details @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teachers @endslot
    @slot('title') Teacher Details @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Teacher Information</h4>
                        <div>
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-primary">
                                <i class="ri-pencil-line align-bottom me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line align-bottom me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Personal Information -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Personal Information</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th width="25%">Employee ID</th>
                                        <td>{{ $teacher->employee_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Full Name</th>
                                        <td>{{ $teacher->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{ ucfirst($teacher->gender) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nationality</th>
                                        <td>{{ $teacher->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td>{{ $teacher->date_of_birth->format('d/m/Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Contact Information</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th width="25%">Email</th>
                                        <td>{{ $teacher->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $teacher->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alternative Phone</th>
                                        <td>{{ $teacher->alternative_phone ?: 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Physical Address</th>
                                        <td>{{ $teacher->physical_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Postal Address</th>
                                        <td>{{ $teacher->postal_address ?: 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Professional Information -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Professional Information</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th width="25%">Specialization</th>
                                        <td>{{ $teacher->specialization }}</td>
                                    </tr>
                                    <tr>
                                        <th>Highest Qualification</th>
                                        <td>{{ $teacher->highest_qualification }}</td>
                                    </tr>
                                    <tr>
                                        <th>Teaching License</th>
                                        <td>{{ $teacher->teaching_license_number ?: 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>License Expiry</th>
                                        <td>{{ $teacher->license_expiry_date ? $teacher->license_expiry_date->format('d/m/Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td>{{ $teacher->joining_date->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge bg-{{ $teacher->is_active ? 'success' : 'danger' }}">
                                                {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Uploaded Documents -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3">Uploaded Documents</h5>
                        <div class="row">
                            @if($teacher->cv_path && Storage::disk('public')->exists($teacher->cv_path))
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $teacher->cv_path) }}" class="btn btn-soft-primary w-100" target="_blank">
                                        <i class="ri-file-text-line me-1"></i> View CV
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        Uploaded: {{ date('d/m/Y H:i', Storage::disk('public')->lastModified($teacher->cv_path)) }}
                                    </small>
                                </div>
                            @endif
                            
                            @if($teacher->teaching_license_path && Storage::disk('public')->exists($teacher->teaching_license_path))
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $teacher->teaching_license_path) }}" class="btn btn-soft-info w-100" target="_blank">
                                        <i class="ri-file-text-line me-1"></i> View Teaching License
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        Uploaded: {{ date('d/m/Y H:i', Storage::disk('public')->lastModified($teacher->teaching_license_path)) }}
                                    </small>
                                </div>
                            @endif
                            
                            @if($teacher->certificates_path && Storage::disk('public')->exists($teacher->certificates_path))
                                <div class="col-md-4 mb-3">
                                    <a href="{{ asset('storage/' . $teacher->certificates_path) }}" class="btn btn-soft-success w-100" target="_blank">
                                        <i class="ri-file-text-line me-1"></i> View Certificates
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        Uploaded: {{ date('d/m/Y H:i', Storage::disk('public')->lastModified($teacher->certificates_path)) }}
                                    </small>
                                </div>
                            @endif
                            
                            @unless($teacher->cv_path || $teacher->teaching_license_path || $teacher->certificates_path)
                                <div class="col-12">
                                    <div class="alert alert-info mb-0">
                                        <i class="ri-information-line me-2"></i> No documents have been uploaded yet.
                                    </div>
                                </div>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection