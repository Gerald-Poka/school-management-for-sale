@extends('layouts.master')
@section('title') Results Management @endsection
@section('css')
<link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet">
<style>
    .grade-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
    }
    .grade-a {
        background-color: rgba(46, 204, 113, 0.1);
        color: #27ae60;
    }
    .grade-b {
        background-color: rgba(52, 152, 219, 0.1);
        color: #2980b9;
    }
    .grade-c {
        background-color: rgba(241, 196, 15, 0.1);
        color: #f39c12;
    }
    .grade-d {
        background-color: rgba(230, 126, 34, 0.1);
        color: #d35400;
    }
    .grade-f {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
    }
    .action-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        margin: 0 0.2rem;
        border-radius: 0.25rem;
    }
    
    .btn-edit {
        background-color: rgba(52, 152, 219, 0.1);
        color: #2980b9;
        border: none;
    }
    
    .btn-edit:hover {
        background-color: rgba(52, 152, 219, 0.2);
        color: #2980b9;
    }
    
    .btn-delete {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
        border: none;
    }
    
    .btn-delete:hover {
        background-color: rgba(231, 76, 60, 0.2);
        color: #c0392b;
    }
</style>
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Results @endslot
    @slot('title') Results Management @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title mb-0">Student Results</h5>
                    <a href="{{ route('admin.results.create') }}" class="btn btn-primary">
                        <i class="ri-add-line align-bottom me-1"></i> Upload Results
                    </a>
                </div>
                
                <form action="{{ route('admin.results.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="academic_level" class="form-select">
                            <option value="">All Levels</option>
                            @foreach($academicLevels as $level)
                                <option value="{{ $level->order }}" {{ request('academic_level') == $level->order ? 'selected' : '' }}>
                                    Standard {{ $level->order }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="subject_id" class="form-select">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <select name="exam_type" class="form-select">
                            <option value="">All Exam Types</option>
                            <option value="Mid Term" {{ request('exam_type') == 'Mid Term' ? 'selected' : '' }}>Mid Term</option>
                            <option value="Final" {{ request('exam_type') == 'Final' ? 'selected' : '' }}>Final</option>
                            <option value="Quiz" {{ request('exam_type') == 'Quiz' ? 'selected' : '' }}>Quiz</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="ri-filter-3-line align-bottom me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.results.index') }}" class="btn btn-light">
                                <i class="ri-refresh-line align-bottom"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Subject</th>
                                <th>Exam Type</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        {{ $result->student->admission_number }} -
                                        {{ $result->student->first_name }} {{ $result->student->last_name }}
                                        <small class="d-block text-muted">
                                            Standard {{ $result->student->academicLevel->order }}
                                        </small>
                                    </td>
                                    <td>{{ $result->subject->name }}</td>
                                    <td>{{ $result->exam_type }}</td>
                                    <td>{{ $result->marks_obtained }}%</td>
                                    <td>
                                        <span class="grade-badge grade-{{ strtolower($result->grade) }}">
                                            {{ $result->grade }}
                                        </span>
                                    </td>
                                    <td>{{ $result->exam_date->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.results.edit', $result->id) }}" 
                                           class="btn action-btn btn-edit" 
                                           title="Edit Result">
                                            <i class="ri-pencil-line align-bottom"></i>
                                        </a>
                                        
                                        <button type="button" 
                                                class="btn action-btn btn-delete" 
                                                onclick="if(confirm('Are you sure you want to delete this result?')) document.getElementById('delete-form-{{ $result->id }}').submit();"
                                                title="Delete Result">
                                            <i class="ri-delete-bin-line align-bottom"></i>
                                        </button>
                                        
                                        <form id="delete-form-{{ $result->id }}" 
                                              action="{{ route('admin.results.destroy', $result->id) }}" 
                                              method="POST" 
                                              class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            order: [[5, 'desc']], // Sort by date descending
            pageLength: 25,
            language: {
                search: "",
                lengthMenu: "_MENU_ results per page",
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function() {
                $('.dataTables_filter input').attr("placeholder", "Search results...");
            }
        });
    });
</script>
@endsection
