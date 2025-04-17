@extends('layouts.master')
@section('title') Teachers List @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teachers @endslot
    @slot('title') All Teachers @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Teachers List</h4>
                    <div class="float-end">
                        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Add New Teacher
                        </a>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Specialization</th>
                                    <th>Joined Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->employee_id }}</td>
                                        <td>{{ $teacher->full_name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ $teacher->specialization }}</td>
                                        <td>{{ $teacher->joining_date->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $teacher->is_active ? 'success' : 'danger' }}">
                                                {{ $teacher->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.teachers.show', $teacher->id) }}" 
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="ri-eye-fill"></i>
                                                </a>
                                                <a href="{{ route('admin.teachers.edit', $teacher->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="ri-pencil-fill"></i>
                                                </a>
                                                <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this teacher?')"
                                                            title="Delete">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No teachers found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $teachers->links() }}
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