@extends('layouts.master')
@section('title') Add New Teacher @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teachers @endslot
    @slot('title') Add New Teacher @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Teacher Registration Form</h4>
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

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Personal Information</h5>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Employee ID</label>
                                    <input type="text" name="employee_id" 
                                           class="form-control" 
                                           value="{{ $employeeId }}" 
                                           readonly>
                                    <small class="text-muted">Auto-generated ID</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">First Name</label>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" 
                                           value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Last Name</label>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" 
                                           value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Nationality</label>
                                    <input type="text" name="nationality" class="form-control @error('nationality') is-invalid @enderror" 
                                           value="{{ old('nationality') }}" required>
                                    @error('nationality')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Gender</label>
                                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                        <!-- <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option> -->
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           value="{{ old('date_of_birth') }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Identification Documents -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Identification Documents</h5>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Birth Certificate Number</label>
                                    <input type="text" name="birth_certificate_number" 
                                           class="form-control @error('birth_certificate_number') is-invalid @enderror" 
                                           value="{{ old('birth_certificate_number') }}">
                                    @error('birth_certificate_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">National ID</label>
                                    <input type="text" name="national_id" class="form-control @error('national_id') is-invalid @enderror" 
                                           value="{{ old('national_id') }}">
                                    @error('national_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Passport Number</label>
                                    <input type="text" name="passport_number" class="form-control @error('passport_number') is-invalid @enderror" 
                                           value="{{ old('passport_number') }}">
                                    @error('passport_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Contact Information</h5>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label required">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                           value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Alternative Phone</label>
                                    <input type="tel" name="alternative_phone" 
                                           class="form-control @error('alternative_phone') is-invalid @enderror" 
                                           value="{{ old('alternative_phone') }}">
                                    @error('alternative_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Physical Address</label>
                                    <textarea name="physical_address" class="form-control @error('physical_address') is-invalid @enderror" 
                                              rows="2" required>{{ old('physical_address') }}</textarea>
                                    @error('physical_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Postal Address</label>
                                    <textarea name="postal_address" class="form-control @error('postal_address') is-invalid @enderror" 
                                              rows="2">{{ old('postal_address') }}</textarea>
                                    @error('postal_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Educational Background -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Educational Background</h5>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Secondary School</label>
                                    <input type="text" name="secondary_school" 
                                           class="form-control @error('secondary_school') is-invalid @enderror" 
                                           value="{{ old('secondary_school') }}">
                                    @error('secondary_school')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Form Four Index</label>
                                    <input type="text" name="form_four_index" 
                                           class="form-control @error('form_four_index') is-invalid @enderror" 
                                           value="{{ old('form_four_index') }}">
                                    @error('form_four_index')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Form Six Index</label>
                                    <input type="text" name="form_six_index" 
                                           class="form-control @error('form_six_index') is-invalid @enderror" 
                                           value="{{ old('form_six_index') }}">
                                    @error('form_six_index')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Diploma Certificate</label>
                                    <input type="text" name="diploma_certificate" 
                                           class="form-control @error('diploma_certificate') is-invalid @enderror" 
                                           value="{{ old('diploma_certificate') }}">
                                    @error('diploma_certificate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Degree Certificate</label>
                                    <input type="text" name="degree_certificate" 
                                           class="form-control @error('degree_certificate') is-invalid @enderror" 
                                           value="{{ old('degree_certificate') }}">
                                    @error('degree_certificate')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Highest Qualification</label>
                                    <input type="text" name="highest_qualification" 
                                           class="form-control @error('highest_qualification') is-invalid @enderror" 
                                           value="{{ old('highest_qualification') }}" required>
                                    @error('highest_qualification')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Professional Information -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Professional Information</h5>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Specialization</label>  <!-- Removed 'required' -->
                                    <input type="text" name="specialization" 
                                           class="form-control @error('specialization') is-invalid @enderror" 
                                           value="{{ old('specialization') }}">
                                    @error('specialization')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Other Qualifications</label>
                                    <textarea name="other_qualifications" 
                                              class="form-control @error('other_qualifications') is-invalid @enderror" 
                                              rows="2">{{ old('other_qualifications') }}</textarea>
                                    @error('other_qualifications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Teaching License Number</label>
                                    <input type="text" name="teaching_license_number" 
                                           class="form-control @error('teaching_license_number') is-invalid @enderror" 
                                           value="{{ old('teaching_license_number') }}">
                                    @error('teaching_license_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">License Expiry Date</label>
                                    <input type="date" name="license_expiry_date" 
                                           class="form-control @error('license_expiry_date') is-invalid @enderror" 
                                           value="{{ old('license_expiry_date') }}">
                                    @error('license_expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">Joining Date</label>
                                    <input type="date" name="joining_date" 
                                           class="form-control @error('joining_date') is-invalid @enderror" 
                                           value="{{ old('joining_date') }}" required>
                                    @error('joining_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Experience and Skills -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Experience and Skills (Optional)</h5>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Previous Experience</label>
                                    <textarea name="previous_experience" 
                                              class="form-control @error('previous_experience') is-invalid @enderror" 
                                              rows="3">{{ old('previous_experience') }}</textarea>
                                    @error('previous_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Subjects Taught</label>
                                    <input type="text" name="subjects_taught" 
                                           class="form-control @error('subjects_taught') is-invalid @enderror" 
                                           value="{{ old('subjects_taught') }}"
                                           placeholder="Separate subjects with commas">
                                    @error('subjects_taught')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ICT Skills</label>
                                    <input type="text" name="ict_skills" 
                                           class="form-control @error('ict_skills') is-invalid @enderror" 
                                           value="{{ old('ict_skills') }}"
                                           placeholder="Separate skills with commas">
                                    @error('ict_skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Language Proficiency</label>
                                    <input type="text" name="language_proficiency" 
                                           class="form-control @error('language_proficiency') is-invalid @enderror" 
                                           value="{{ old('language_proficiency') }}"
                                           placeholder="Separate languages with commas">
                                    @error('language_proficiency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Responsibilities</label>
                                    <textarea name="responsibilities" 
                                              class="form-control @error('responsibilities') is-invalid @enderror" 
                                              rows="3">{{ old('responsibilities') }}</textarea>
                                    @error('responsibilities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Achievements</label>
                                    <textarea name="achievements" 
                                              class="form-control @error('achievements') is-invalid @enderror" 
                                              rows="3">{{ old('achievements') }}</textarea>
                                    @error('achievements')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Classroom Management Skills</label>
                                    <textarea name="classroom_management_skills" 
                                              class="form-control @error('classroom_management_skills') is-invalid @enderror" 
                                              rows="3">{{ old('classroom_management_skills') }}</textarea>
                                    @error('classroom_management_skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Document Uploads -->
                        <div class="row mb-4">
                            <h5 class="mb-3">Document Uploads (Optional)</h5>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">CV</label>
                                    <input type="file" name="cv" class="form-control @error('cv') is-invalid @enderror">
                                    @error('cv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Teaching License</label>
                                    <input type="file" name="teaching_license" 
                                           class="form-control @error('teaching_license') is-invalid @enderror">
                                    @error('teaching_license')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Certificates</label>
                                    <input type="file" name="certificates" 
                                           class="form-control @error('certificates') is-invalid @enderror">
                                    @error('certificates')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Recommendation Letters</label>
                                    <input type="file" name="recommendation_letters" 
                                           class="form-control @error('recommendation_letters') is-invalid @enderror">
                                    @error('recommendation_letters')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ID Document</label>
                                    <input type="file" name="id_document" 
                                           class="form-control @error('id_document') is-invalid @enderror">
                                    @error('id_document')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Birth Certificate</label>
                                    <input type="file" name="birth_certificate" 
                                           class="form-control @error('birth_certificate') is-invalid @enderror">
                                    @error('birth_certificate')
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
                                           id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active Status</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Register Teacher</button>
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