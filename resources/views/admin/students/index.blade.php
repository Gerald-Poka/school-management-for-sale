@extends('layouts.master')
@section('title') Students @endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') Students @endslot
    @slot('title') View Students @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Students List</h5>
                        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">Add New Student</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {!! nl2br(e(session('success'))) !!}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Adm No</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr>
                                        <td>
                                            @if($student->profile_picture)
                                                <img src="{{ Storage::url($student->profile_picture) }}" 
                                                     alt="Profile Picture"
                                                     class="rounded-circle"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                                     style="width: 40px; height: 40px;">
                                                    {{ substr($student->first_name, 0, 1) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $student->admission_number }}</td>
                                        <td>
                                            {{ $student->first_name }} 
                                            {{ $student->middle_name }} 
                                            {{ $student->last_name }}
                                        </td>
                                        <td>{{ $student->academicLevel->name }}</td>
                                        <td>{{ ucfirst($student->gender) }}</td>
                                        <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') : '-' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }}">
                                                {{ $student->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.students.show', $student) }}" 
                                               class="btn btn-sm btn-info">
                                                View
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student) }}" 
                                               class="btn btn-sm btn-primary">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.students.destroy', $student) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this student?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No students found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $students->links() }}
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