@extends('layouts.master')
@section('title') Timetables @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Timetables @endslot
    @slot('title') View Timetables @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Class Timetables</h5>
                        <a href="{{ route('admin.timetables.create') }}" class="btn btn-primary">Create New Timetable</a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($academicLevels as $level)
                        @php
                            $timetable = $timetables->where('academic_level_id', $level->id)->first();
                        @endphp
                        <div class="mb-4">
                            <h4>{{ $level->name }} Timetable</h4>
                            @if($timetable)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
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
                                            @foreach($timetable->slots->groupBy('start_time') as $time => $timeSlots)
                                                <tr>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($time)->format('H:i') }} - 
                                                        {{ \Carbon\Carbon::parse($timeSlots->first()->end_time)->format('H:i') }}
                                                    </td>
                                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                                        @php
                                                            $slot = $timeSlots->where('day_of_week', $day)->first();
                                                        @endphp
                                                        <td class="{{ $slot && $slot->type !== 'class' ? 'table-secondary' : '' }}">
                                                            @if($slot)
                                                                @if($slot->type === 'break')
                                                                    <span class="badge bg-warning">Break Time</span>
                                                                @elseif($slot->type === 'lunch')
                                                                    <span class="badge bg-info">Lunch Break</span>
                                                                @else
                                                                    <div>
                                                                        <strong>{{ $slot->subject->name ?? 'No Subject' }}</strong><br>
                                                                        Room: {{ $slot->room_number }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    No timetable created yet for {{ $level->name }}.
                                    <a href="{{ route('admin.timetables.create', ['level' => $level->id]) }}" 
                                       class="alert-link">Create one now</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
    function loadTeachers(slotId, subjectId) {
        const teachersList = document.getElementById(`teachersList${slotId}`);
        
        fetch(`{{ url('admin/timetables/slots') }}/${slotId}/subject-teachers`)
            .then(response => response.json())
            .then(data => {
                teachersList.innerHTML = ''; // Clear loading message
                
                if (data.teachers && data.teachers.length > 0) {
                    data.teachers.forEach(teacher => {
                        const li = document.createElement('li');
                        li.innerHTML = `
                            <a class="dropdown-item" href="#" onclick="assignTeacher(${slotId}, ${teacher.id}); return false;">
                                ${teacher.first_name} ${teacher.last_name}
                                <span class="badge bg-info float-end">
                                    ${teacher.schedules_count || 0} classes
                                </span>
                            </a>
                        `;
                        teachersList.appendChild(li);
                    });
                } else {
                    teachersList.innerHTML = `
                        <li><span class="dropdown-item text-muted">No teachers available</span></li>
                    `;
                }
            })
            .catch(error => {
                teachersList.innerHTML = `
                    <li><span class="dropdown-item text-danger">Error loading teachers</span></li>
                `;
                console.error('Error:', error);
            });
    }

    function assignTeacher(slotId, teacherId) {
        // Show loading state
        const dropdown = document.getElementById(`assignTeacherDropdown${slotId}`);
        dropdown.disabled = true;
        dropdown.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Assigning...';

        fetch(`{{ url('admin/timetables/slots') }}/${slotId}/assign-teacher`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ teacher_id: teacherId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message before reload
                const successDiv = document.createElement('div');
                successDiv.className = 'alert alert-success mt-2';
                successDiv.textContent = data.message;
                dropdown.parentNode.insertBefore(successDiv, dropdown.nextSibling);
                
                // Reload after short delay to show success message
                setTimeout(() => location.reload(), 1000);
            } else {
                // Show error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger mt-2';
                errorDiv.textContent = data.message || 'Error assigning teacher';
                dropdown.parentNode.insertBefore(errorDiv, dropdown.nextSibling);
                
                // Reset button state
                dropdown.disabled = false;
                dropdown.innerHTML = 'Assign Teacher';
                
                // Remove error message after 3 seconds
                setTimeout(() => errorDiv.remove(), 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-2';
            errorDiv.textContent = 'Network error while assigning teacher';
            dropdown.parentNode.insertBefore(errorDiv, dropdown.nextSibling);
            
            // Reset button state
            dropdown.disabled = false;
            dropdown.innerHTML = 'Assign Teacher';
            
            // Remove error message after 3 seconds
            setTimeout(() => errorDiv.remove(), 3000);
        });
    }
</script>
@endsection
