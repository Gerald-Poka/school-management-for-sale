@extends('layouts.master')
@section('title') Edit Subject @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subjects @endslot
    @slot('title') Edit Subject @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Subject</h4>
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

                    <form action="{{ route('admin.subjects.update', $subject) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Subject Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       name="name" 
                                       value="{{ old('name', $subject->name) }}" 
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject Code</label>
                                <input type="text" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       name="code" 
                                       value="{{ old('code', $subject->code) }}" 
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Level</label>
                                <select class="form-select @error('level') is-invalid @enderror" name="level" required>
                                    @foreach(['Standard 1', 'Standard 2', 'Standard 3', 'Standard 4', 'Standard 5', 'Standard 6'] as $level)
                                        <option value="{{ $level }}" {{ old('level', $subject->level) == $level ? 'selected' : '' }}>
                                            {{ $level }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Credits</label>
                                <input type="number" 
                                       class="form-control @error('credits') is-invalid @enderror" 
                                       name="credits" 
                                       value="{{ old('credits', $subject->credits) }}" 
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" 
                                      rows="4">{{ old('description', $subject->description) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">PDF Book</label>
                            <input type="file" 
                                   class="form-control @error('pdf_link') is-invalid @enderror" 
                                   name="pdf_link" 
                                   accept=".pdf">
                            @if($subject->pdf_link)
                                <div class="mt-2">
                                    <small class="text-muted">Current file: 
                                        <a href="{{ asset($subject->pdf_link) }}" target="_blank">
                                            <i class="las la-file-pdf"></i> View current PDF
                                        </a>
                                    </small>
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary me-1">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Subject</button>
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
        // Get all alert messages
        const alerts = document.querySelectorAll('.alert');
        
        // Add fade out effect after 3 seconds
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 1000);
            }, 3000);
        });
    });
</script>
@endsection