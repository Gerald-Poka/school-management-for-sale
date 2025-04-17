@extends('layouts.master')
@section('title') Subject Details @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subjects @endslot
    @slot('title') Subject Details @endslot
@endcomponent

<div class="container-fluid">
    <!-- Subject Information Card -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Subject Information</h5>
                        <div class="hstack gap-2">
                            <a href="{{ route('admin.subjects.edit', $subject) }}" class="btn btn-info">
                                <i class="las la-edit"></i> Edit Subject
                            </a>
                            <form action="{{ route('admin.subjects.destroy', $subject) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this subject?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="las la-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold">Subject Details</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th width="140">Subject Code:</th>
                                            <td>{{ $subject->code }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subject Name:</th>
                                            <td>{{ $subject->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Level:</th>
                                            <td>{{ $subject->level }}</td>
                                        </tr>
                                        <tr>
                                            <th>Credits:</th>
                                            <td>{{ $subject->credits }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($subject->description)
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold">Description</h6>
                                <p class="text-muted">{{ $subject->description }}</p>
                            </div>
                            @endif

                            @if($subject->pdf_link)
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold">Course Material</h6>
                                <a href="{{ asset($subject->pdf_link) }}" 
                                   class="btn btn-success" 
                                   target="_blank">
                                    <i class="las la-file-pdf"></i> View PDF
                                </a>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted fw-bold">Topics and Activities</h6>
                                @php
                                    // Enable query logging
                                    \DB::enableQueryLog();
                                    
                                    $topics = $subject->topics()
                                        ->where('class_level', 'Primary ' . filter_var($subject->level, FILTER_SANITIZE_NUMBER_INT))
                                        ->with(['subtopics', 'activities'])
                                        ->get();
                                @endphp

                                @if($topics->count() > 0)
                                    @foreach($topics as $topic)
                                        <div class="card mb-3 shadow-sm">
                                            <div class="card-header bg-light">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="mb-0 text-primary">{{ $topic->name }}</h6>
                                                    <span class="badge bg-info">{{ $topic->duration }}</span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @if($topic->subtopics->count() > 0)
                                                    <div class="mb-3">
                                                        <strong class="text-muted">Subtopics:</strong>
                                                        <ul class="list-group list-group-flush mt-2">
                                                            @foreach($topic->subtopics as $subtopic)
                                                                <li class="list-group-item border-0 ps-0">
                                                                    <i class="las la-check-circle text-success me-2"></i>
                                                                    {{ $subtopic->name }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                @if($topic->activities->count() > 0)
                                                    <div class="mt-3">
                                                        <strong class="text-muted">Activities:</strong>
                                                        <ul class="list-group list-group-flush mt-2">
                                                            @foreach($topic->activities as $activity)
                                                                <li class="list-group-item border-0 ps-0">
                                                                    <div class="d-flex align-items-center">
                                                                        <i class="las la-tasks text-primary me-2"></i>
                                                                        <div>
                                                                            <span class="badge bg-soft-primary text-primary me-2">
                                                                                {{ $activity->type }}
                                                                            </span>
                                                                            {{ $activity->title }}
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        <i class="las la-info-circle me-2"></i>
                                        No topics have been added for {{ $subject->name }} ({{ $subject->level }}) yet.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<style>
    .bg-soft-primary {
        background-color: rgba(85, 110, 230, 0.1);
    }
    .card .shadow-sm {
        transition: all 0.3s ease;
    }
    .card .shadow-sm:hover {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .badge {
        font-weight: 500;
    }
</style>
@endsection