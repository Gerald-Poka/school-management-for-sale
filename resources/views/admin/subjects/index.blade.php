@extends('layouts.master')
@section('title') All Subjects @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subjects @endslot
    @slot('title') All Subjects @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">

        <div class="col-xl-12">
            <div class="card">
            @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
            @endif
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Subjects List</h5>
                        <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="las la-filter"></i> Filter
                        </button>
                        <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">Add New Subject</a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive table-card">
                        <table class="table table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Credits</th>
                                    <th scope="col" style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->level }}</td>
                                        <td>{{ $subject->credits }}</td>
                                        <td>
                                            <div class="hstack gap-2">
                                                <a href="{{ route('admin.subjects.show', $subject) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="View Details">
                                                    <i class="las la-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.subjects.edit', $subject) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Edit">
                                                    <i class="las la-edit"></i>
                                                </a>
                                                @if($subject->pdf_link)
                                                    <a href="{{ asset($subject->pdf_link) }}" 
                                                       class="btn btn-sm btn-success" 
                                                       target="_blank" 
                                                       title="View PDF">
                                                        <i class="las la-file-pdf"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.subjects.destroy', $subject) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Delete">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No subjects found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.subjects.modals.filter')

@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add active class to filter button if filters are applied
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.toString()) {
            document.querySelector('.btn-light').classList.add('active');
        }
    });
</script>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection