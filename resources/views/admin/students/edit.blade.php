@extends('layouts.master')
@section('title') Edit Student @endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') Students @endslot
    @slot('title') Edit Student @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Read-only Fields -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Admission Number</label>
                                <input type="text" class="form-control" value="{{ $student->admission_number }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" 
                                       value="{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}" 
                                       readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date of Birth</label>
                                <input type="text" class="form-control" 
                                       value="{{ $student->date_of_birth->format('d/m/Y') }}" 
                                       readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Gender</label>
                                <input type="text" class="form-control" value="{{ ucfirst($student->gender) }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date of Admission</label>
                                <input type="text" class="form-control" 
                                       value="{{ $student->date_of_admission->format('d/m/Y') }}" 
                                       readonly>
                            </div>
                        </div>

                        <!-- Editable Fields -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Academic Level</label>
                                <select name="academic_level_id" class="form-select @error('academic_level_id') is-invalid @enderror">
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->id }}" 
                                            {{ old('academic_level_id', $student->academic_level_id) == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('academic_level_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Special Needs</label>
                                <textarea name="special_needs" class="form-control @error('special_needs') is-invalid @enderror" 
                                          rows="2">{{ old('special_needs', $student->special_needs) }}</textarea>
                                @error('special_needs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Profile Picture</label>
                                <input type="file" name="profile_picture" 
                                       class="form-control @error('profile_picture') is-invalid @enderror">
                                @error('profile_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_active" class="form-check-input" 
                                           value="1" {{ old('is_active', $student->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Student</button>
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