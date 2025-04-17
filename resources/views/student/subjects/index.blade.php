@extends('layouts.master')
@section('title') My Subjects @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 fw-bold">My Subjects</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($subjects->count() > 0)
                        <div class="row">
                            @foreach($subjects as $subject)
                                <div class="col-md-6 col-xl-3 mb-4">
                                    <div class="card h-100 shadow-sm hover-shadow-lg transition-all">
                                        <div class="card-header bg-light">
                                            <span class="badge bg-success float-end">{{ $subject->credits }} Credits</span>
                                            <h5 class="card-title mb-0 text-primary">{{ $subject->code }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex flex-column h-100">
                                                <h6 class="fw-bold mb-3">{{ $subject->name }}</h6>
                                                
                                                <div class="mt-auto">
                                                    <div class="d-grid gap-2">
                                                        <a href="{{ route('student.subjects.show', $subject) }}" 
                                                           class="btn btn-primary btn-sm" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View Details">
                                                            <i class="las la-eye me-1"></i> Details
                                                        </a>
                                                        
                                                        @if($subject->pdf_link)
                                                        <a href="{{ route('student.subjects.pdf', $subject) }}" 
                                                           class="btn btn-outline-info btn-sm"
                                                           target="_blank"
                                                           data-bs-toggle="tooltip" 
                                                           title="View PDF">
                                                            <i class="las la-file-pdf me-1"></i> PDF
                                                        </a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="text-center p-4">
                                    <div class="mb-4">
                                        <i class="las la-book-open display-1 text-muted opacity-50"></i>
                                    </div>
                                    <h4 class="text-primary">No Subjects Available</h4>
                                    <p class="text-muted">No subjects have been registered yet for your academic level.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<style>
    .hover-shadow-lg {
        transition: all 0.3s ease;
    }
    .hover-shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .btn-group {
        width: 100%;
    }
    .d-grid.gap-2 .btn {
        text-align: center;
        display: block;
        width: 100%;
    }
    .d-grid.gap-2 .btn-primary {
        padding: 0.5rem 1rem;
    }
    .d-grid.gap-2 .btn-outline-info {
        padding: 0.4rem 1rem;
    }
</style>
@endsection