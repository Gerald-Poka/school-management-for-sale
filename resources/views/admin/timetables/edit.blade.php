@extends('layouts.master')
@section('title') Edit Timetable @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Timetables @endslot
    @slot('title') Edit Timetable @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.timetables.update', $timetable->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Academic Level</label>
                                    <select name="academic_level_id" class="form-select" required>
                                        <option value="">Select Class</option>
                                        @foreach($academicLevels as $level)
                                            <option value="{{ $level->id }}" {{ $timetable->academic_level_id == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Academic Year</label>
                                    <input type="text" name="academic_year" class="form-control" 
                                           value="{{ $timetable->academic_year }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Term</label>
                                    <select name="term" class="form-select" required>
                                        <option value="1" {{ $timetable->term == 1 ? 'selected' : '' }}>Term 1</option>
                                        <option value="2" {{ $timetable->term == 2 ? 'selected' : '' }}>Term 2</option>
                                        <option value="3" {{ $timetable->term == 3 ? 'selected' : '' }}>Term 3</option>
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
                                                        @php
                                                            $slotInfo = $slotData[$day][$slot[0]] ?? null;
                                                            $subjectId = $slotInfo['subject_id'] ?? null;
                                                            $teacherId = $slotInfo['teacher_id'] ?? null;
                                                            $slotId = $slotInfo['slot_id'] ?? null;
                                                        @endphp
                                                        
                                                        <div class="mb-2">
                                                            <select name="subjects[{{ $day }}][{{ $slot[0] }}]" 
                                                                    class="form-select subject-select" 
                                                                    data-day="{{ $day }}" 
                                                                    data-time="{{ $slot[0] }}"
                                                                    data-slot-id="{{ $slotId }}">
                                                                <option value="">Select Subject</option>
                                                                @foreach($subjects as $subject)
                                                                    <option value="{{ $subject->id }}" {{ $subjectId == $subject->id ? 'selected' : '' }}>
                                                                        {{ $subject->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        
                                                        @if($slotId)
                                                            <div class="teacher-container" id="teacher-{{ $day }}-{{ $slot[0] }}">
                                                                @if($teacherId)
                                                                    <span class="badge bg-success">
                                                                        {{ $timetable->slots->where('id', $slotId)->first()->teacher->first_name ?? '' }}
                                                                        {{ $timetable->slots->where('id', $slotId)->first()->teacher->last_name ?? '' }}
                                                                    </span>
                                                                    <button type="button" class="btn btn-sm btn-outline-primary assign-teacher-btn"
                                                                            data-slot-id="{{ $slotId }}">
                                                                        Change
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-sm btn-outline-primary assign-teacher-btn"
                                                                            data-slot-id="{{ $slotId }}">
                                                                        Assign Teacher
                                                                    </button>
                                                                @endif
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

                        <div class="text-end mt-4">
                            <a href="{{ route('admin.timetables.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Timetable</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Teacher Assignment Modal -->
<div class="modal fade" id="assignTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Select Teacher</label>
                    <select id="teacherSelect" class="form-select">
                        <option value="">Loading teachers...</option>
                    </select>
                </div>
                <div id="teacherSchedule" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveTeacherAssignment">Assign</button>
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

        // Subject selection change handler
        const subjectSelects = document.querySelectorAll('.subject-select');
        subjectSelects.forEach(select => {
            select.addEventListener('change', function() {
                const day = this.dataset.day;
                const time = this.dataset.time;
                const slotId = this.dataset.slotId;
                const subjectId = this.value;
                
                // If there's a slot ID, update the subject
                if (slotId) {
                    updateSlotSubject(slotId, subjectId);
                }
            });
        });

        // Teacher assignment button handler
        const assignButtons = document.querySelectorAll('.assign-teacher-btn');
        const teacherModal = new bootstrap.Modal(document.getElementById('assignTeacherModal'));
        let currentSlotId = null;

        assignButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                currentSlotId = this.dataset.slotId;
                loadAvailableTeachers(currentSlotId);
                teacherModal.show();
            });
        });

        // Save teacher assignment
        document.getElementById('saveTeacherAssignment').addEventListener('click', function() {
            const teacherId = document.getElementById('teacherSelect').value;
            if (!teacherId) {
                alert('Please select a teacher');
                return;
            }

            assignTeacher(currentSlotId, teacherId);
        });

        // Function to update slot subject
        function updateSlotSubject(slotId, subjectId) {
            fetch(`/admin/timetable-slots/${slotId}/update-subject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ subject_id: subjectId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the UI or show success message
                    const teacherContainer = document.getElementById(`teacher-${data.day}-${data.time}`);
                    if (teacherContainer) {
                        teacherContainer.innerHTML = `
                            <button type="button" class="btn btn-sm btn-outline-primary assign-teacher-btn"
                                    data-slot-id="${slotId}">
                                Assign Teacher
                            </button>
                        `;
                    }
                } else {
                    alert(data.message || 'Error updating subject');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the subject');
            });
        }

        // Function to load available teachers
        function loadAvailableTeachers(slotId) {
            const teacherSelect = document.getElementById('teacherSelect');
            teacherSelect.innerHTML = '<option value="">Loading teachers...</option>';
            
            fetch(`/admin/timetable-slots/${slotId}/available-teachers`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    teacherSelect.innerHTML = '<option value="">Select Teacher</option>';
                    data.data.forEach(teacher => {
                        const option = document.createElement('option');
                        option.value = teacher.id;
                        option.textContent = `${teacher.first_name} ${teacher.last_name}`;
                        teacherSelect.appendChild(option);
                    });
                } else {
                    teacherSelect.innerHTML = '<option value="">No teachers available</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                teacherSelect.innerHTML = '<option value="">Error loading teachers</option>';
            });
        }

        // Function to assign teacher
        function assignTeacher(slotId, teacherId) {
            fetch(`/admin/timetable-slots/${slotId}/assign-teacher`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ teacher_id: teacherId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    teacherModal.hide();
                    
                    // Update UI
                    const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                    if (slot) {
                        const day = slot.dataset.day;
                        const time = slot.dataset.time;
                        const teacherContainer = document.getElementById(`teacher-${day}-${time}`);
                        
                        if (teacherContainer) {
                            teacherContainer.innerHTML = `
                                <span class="badge bg-success">${data.teacher.name}</span>
                                <button type="button" class="btn btn-sm btn-outline-primary assign-teacher-btn"
                                        data-slot-id="${slotId}">
                                    Change
                                </button>
                            `;
                            
                            // Re-attach event listener
                            teacherContainer.querySelector('.assign-teacher-btn').addEventListener('click', function() {
                                currentSlotId = this.dataset.slotId;
                                loadAvailableTeachers(currentSlotId);
                                teacherModal.show();
                            });
                        }
                    }
                } else {
                    alert(data.message || 'Error assigning teacher');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while assigning the teacher');
            });
        }
    });
</script>
@endsection
