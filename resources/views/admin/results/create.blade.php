@extends('layouts.master')
@section('title') Upload Results @endsection

@section('css')
<style>
    .action-btn {
        padding: 0.5rem 1.5rem;
        margin: 0 0.25rem;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Results @endslot
    @slot('title') Upload New Result @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        @include('partials.notifications')
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.results.create') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Academic Level</label>
                                <select class="form-select" id="academic_level" name="academic_level" onchange="this.form.submit()">
                                    <option value="">Select Level</option>
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->order }}" {{ $selectedLevel == $level->order ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>

                <form action="{{ route('admin.results.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="academic_level" value="{{ $selectedLevel }}">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Student</label>
                                <select class="form-select" name="student_id" id="student_id" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->admission_number }} - {{ $student->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Subject</label>
                                <select class="form-select" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Exam Type</label>
                                <select class="form-select" name="exam_type" required>
                                    <option value="">Select Type</option>
                                    <option value="Mid Term">Mid Term</option>
                                    <option value="Final">Final</option>
                                    <option value="Quiz">Quiz</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Marks Obtained</label>
                                <input type="number" class="form-control" name="marks_obtained" 
                                       min="0" max="100" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Grade</label>
                                <select class="form-select" name="grade" required>
                                    <option value="">Select Grade</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="F">F</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Exam Date</label>
                                <input type="date" class="form-control" name="exam_date" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea class="form-control" name="remarks" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary action-btn">
                                    <i class="ri-save-line align-bottom me-1"></i> Save Result
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{ URL::asset('build/libs/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize select2 for better dropdown experience
        $('#student_id').select2({
            placeholder: "Select a student",
            allowClear: true
        });
    });
</script>
@endsection