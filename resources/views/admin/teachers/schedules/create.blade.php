@extends('layouts.master')
@section('title') Create Teaching Schedule @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teaching Schedules @endslot
    @slot('title') Create Schedule @endslot
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
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.teachers.schedules.store') }}" method="POST" id="schedule-form">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Teacher</label>
                                <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                        name="teacher_id" 
                                        required>
                                    <option value="">Select Teacher</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" 
                                                {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <select class="form-select @error('subject_id') is-invalid @enderror" 
                                        name="subject_id" 
                                        required>
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" 
                                                {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Academic Level</label>
                                <select class="form-select @error('academic_level_id') is-invalid @enderror" 
                                        name="academic_level_id" 
                                        id="academic-level-select"
                                        required>
                                    <option value="">Select Level</option>
                                    @foreach($academicLevels as $level)
                                        <option value="{{ $level->id }}" 
                                                data-order="{{ $level->order }}"
                                                {{ old('academic_level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Wing</label>
                                <select class="form-select @error('wing') is-invalid @enderror" 
                                        name="wing" 
                                        id="wing-select"
                                        required>
                                    <option value="">Select Wing</option>
                                    <option value="A" {{ old('wing') == 'A' ? 'selected' : '' }}>Wing A</option>
                                    <option value="B" {{ old('wing') == 'B' ? 'selected' : '' }}>Wing B</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Day of Week</label>
                                <select class="form-select @error('day_of_week') is-invalid @enderror" 
                                        name="day_of_week" 
                                        required>
                                    <option value="">Select Day</option>
                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                        <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Number</label>
                                <input type="text" 
                                       class="form-control @error('room_number') is-invalid @enderror" 
                                       name="room_number" 
                                       value="{{ old('room_number') }}"
                                       required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" 
                                       class="form-control @error('start_time') is-invalid @enderror" 
                                       name="start_time" 
                                       id="start-time"
                                       value="{{ old('start_time') }}"
                                       required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">End Time</label>
                                <input type="time" 
                                       class="form-control @error('end_time') is-invalid @enderror" 
                                       name="end_time" 
                                       id="end-time"
                                       value="{{ old('end_time') }}"
                                       required>
                                <div id="time-error" class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Create Schedule</button>
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
    const form = document.getElementById('schedule-form');
    const startTime = document.getElementById('start-time');
    const endTime = document.getElementById('end-time');
    const academicLevelSelect = document.getElementById('academic-level-select');
    const wingSelect = document.getElementById('wing-select');
    const timeError = document.getElementById('time-error');

    // Automatically set wing based on academic level
    academicLevelSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const order = parseInt(selectedOption.dataset.order);
        
        // Assuming lower orders (1-3) are Wing A, higher orders (4-6) are Wing B
        wingSelect.value = order <= 3 ? 'A' : 'B';
    });

    // Validate 2-hour time slot
    function validateTimeSlot() {
        if (startTime.value && endTime.value) {
            const start = new Date(`2024-01-01 ${startTime.value}`);
            const end = new Date(`2024-01-01 ${endTime.value}`);
            const diffHours = (end - start) / (1000 * 60 * 60);

            if (diffHours !== 2) {
                timeError.textContent = 'Teaching duration must be exactly 2 hours';
                endTime.classList.add('is-invalid');
                return false;
            } else {
                timeError.textContent = '';
                endTime.classList.remove('is-invalid');
                return true;
            }
        }
        return true;
    }

    // Auto-calculate end time
    startTime.addEventListener('change', function() {
        if (this.value) {
            const start = new Date(`2024-01-01 ${this.value}`);
            start.setHours(start.getHours() + 2);
            endTime.value = start.toTimeString().substring(0, 5);
            validateTimeSlot();
        }
    });

    endTime.addEventListener('change', validateTimeSlot);

    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateTimeSlot()) {
            e.preventDefault();
        }
    });
});
</script>
@endsection