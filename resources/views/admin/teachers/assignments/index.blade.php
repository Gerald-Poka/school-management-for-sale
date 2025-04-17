@extends('layouts.master')
@section('title') Teacher Assignments @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teachers @endslot
    @slot('title') Subject Assignments @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Teacher Subject Assignments</h4>
                        <a href="{{ route('admin.teachers.assignments.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> New Assignment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Teacher</th>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Academic Year</th>
                                    <th>Term</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                    <tr>
                                        <td>{{ $assignment->teacher->full_name }}</td>
                                        <td>{{ $assignment->subject->name }}</td>
                                        <td>{{ $assignment->academicLevel->name }}</td>
                                        <td>{{ $assignment->academic_year }}</td>
                                        <td>Term {{ $assignment->term }}</td>
                                        <td>
                                            <span class="badge bg-{{ $assignment->is_active ? 'success' : 'danger' }}">
                                                {{ $assignment->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.teachers.assignments.edit', $assignment->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                <form action="{{ route('admin.teachers.assignments.destroy', $assignment->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this assignment?')"
                                                            title="Delete">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No assignments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $assignments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection