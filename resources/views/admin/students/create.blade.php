@extends('layouts.master')
@section('title') Add Student @endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') Students @endslot
    @slot('title') Add New Student @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Student Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Admission Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text border-success bg-success bg-opacity-10">
                                                <i class="las la-id-card text-success"></i>
                                            </span>
                                            <input type="text" 
                                                   class="form-control fw-bold border-success text-success bg-success bg-opacity-10" 
                                                   value="{{ $newAdmissionNumber }}" 
                                                   readonly>
                                            <input type="hidden" name="admission_number" value="{{ $newAdmissionNumber }}">
                                        </div>
                                        <small class="text-muted">Auto-generated admission number</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" 
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Middle Name</label>
                                        <input type="text" name="middle_name" 
                                               class="form-control @error('middle_name') is-invalid @enderror"
                                               value="{{ old('middle_name') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" 
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               value="{{ old('last_name') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="date_of_birth" 
                                               class="form-control @error('date_of_birth') is-invalid @enderror"
                                               value="{{ old('date_of_birth') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Class</label>
                                        <select name="academic_level_id" 
                                                class="form-select @error('academic_level_id') is-invalid @enderror" required>
                                            <option value="">Select Class</option>
                                            @foreach($academicLevels as $level)
                                                <option value="{{ $level->id }}" 
                                                    {{ old('academic_level_id') == $level->id ? 'selected' : '' }}>
                                                    {{ $level->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Admission</label>
                                        <input type="date" name="date_of_admission" 
                                               class="form-control @error('date_of_admission') is-invalid @enderror"
                                               value="{{ old('date_of_admission') }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Special Needs</label>
                                        <textarea name="special_needs" 
                                                  class="form-control @error('special_needs') is-invalid @enderror"
                                                  rows="3">{{ old('special_needs') }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_picture" 
                                               class="form-control @error('profile_picture') is-invalid @enderror"
                                               accept="image/*">
                                        <small class="text-muted">Max file size: 2MB. Allowed types: JPG, PNG</small>
                                        @error('profile_picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Guardian Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="guardian_full_name" 
                                               class="form-control @error('guardian_full_name') is-invalid @enderror"
                                               value="{{ old('guardian_full_name') }}" required>
                                        @error('guardian_full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Relationship</label>
                                        <select name="guardian_relationship" 
                                                class="form-select @error('guardian_relationship') is-invalid @enderror" required>
                                            <option value="">Select Relationship</option>
                                            <option value="father" {{ old('guardian_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                                            <option value="mother" {{ old('guardian_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                                            <option value="uncle" {{ old('guardian_relationship') == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                            <option value="aunt" {{ old('guardian_relationship') == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                            <option value="guardian" {{ old('guardian_relationship') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                                            <option value="other" {{ old('guardian_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Primary Phone</label>
                                        <input type="text" name="guardian_primary_phone" 
                                               class="form-control @error('guardian_primary_phone') is-invalid @enderror"
                                               value="{{ old('guardian_primary_phone') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Alternative Phone</label>
                                        <input type="text" name="guardian_alternative_phone" 
                                               class="form-control @error('guardian_alternative_phone') is-invalid @enderror"
                                               value="{{ old('guardian_alternative_phone') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="guardian_email" 
                                               class="form-control @error('guardian_email') is-invalid @enderror"
                                               value="{{ old('guardian_email') }}" required>
                                        @error('guardian_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">This email will be used for both guardian contact and student login</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Occupation</label>
                                        <input type="text" name="guardian_occupation" 
                                               class="form-control @error('guardian_occupation') is-invalid @enderror"
                                               value="{{ old('guardian_occupation') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Residential Address</label>
                                        <textarea name="guardian_residential_address" 
                                                  class="form-control @error('guardian_residential_address') is-invalid @enderror"
                                                  rows="3" required>{{ old('guardian_residential_address') }}</textarea>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_emergency_contact" 
                                               class="form-check-input @error('is_emergency_contact') is-invalid @enderror"
                                               value="1" {{ old('is_emergency_contact') ? 'checked' : '' }}>
                                        <label class="form-check-label">Emergency Contact</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Student</button>
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

