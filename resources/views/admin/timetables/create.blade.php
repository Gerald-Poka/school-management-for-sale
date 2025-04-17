@extends('layouts.master')
@section('title') Create Timetable @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Timetables @endslot
    @slot('title') Create Timetable @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.timetables.store') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Academic Level</label>
                                    <select name="academic_level_id" class="form-select" required>
                                        <option value="">Select Class</option>
                                        @foreach($academicLevels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Academic Year</label>
                                    <input type="text" name="academic_year" class="form-control" 
                                           value="{{ date('Y').'-'.(date('Y')+1) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Term</label>
                                    <select name="term" class="form-select" required>
                                        <option value="1">Term 1</option>
                                        <option value="2">Term 2</option>
                                        <option value="3">Term 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timeSlots as $slot)
                                        <tr>
                                            <td>{{ $slot[0] }} - {{ $slot[1] }}</td>
                                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                                <td>
                                                    @if($slot[0] === '10:45')
                                                        <span class="badge bg-warning">Break Time</span>
                                                    @elseif($slot[0] === '13:15')
                                                        <span class="badge bg-info">Lunch Break</span>
                                                    @else
                                                        <select name="subjects[{{ $day }}][{{ $slot[0] }}]" class="form-select">
                                                            <option value="">Select Subject</option>
                                                            @foreach($subjects as $subject)
                                                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.timetables.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Timetable</button>
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
        // Add validation to ensure no duplicate subjects per day
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            let hasError = false;

            days.forEach(day => {
                const subjects = new Set();
                const selects = document.querySelectorAll(`select[name^="subjects[${day}]"]`);
                
                selects.forEach(select => {
                    if (select.value && subjects.has(select.value)) {
                        hasError = true;
                        alert(`Duplicate subject found in ${day}`);
                        e.preventDefault();
                        return;
                    }
                    if (select.value) {
                        subjects.add(select.value);
                    }
                });
            });
        });
    });
</script>
@endsection
