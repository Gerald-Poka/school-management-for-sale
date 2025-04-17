@extends('layouts.master')
@section('title') {{ $subject->name }} - Subject Details @endsection

@section('css')
<style>
    .subject-header {
        background: linear-gradient(to right, #4b38b3, #6f42c1);
        padding: 2rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
    }
    .subject-header h2 {
        color: white;
        margin-bottom: 0.5rem;
    }
    .subject-header .meta-info {
        color: rgba(255, 255, 255, 0.8);
    }
    .info-card {
        height: 100%;
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-5px);
    }
    .info-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-bottom: 1rem;
    }
    .bg-soft-warning {
        background-color: rgba(255, 199, 0, 0.1);
    }
    
    .bg-soft-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .bg-soft-primary {
        background-color: rgba(85, 110, 230, 0.1);
    }
    
    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .card .shadow-sm {
        transition: all 0.3s ease;
    }
    
    .card .shadow-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .list-group-item {
        background: transparent;
    }

    .topic-card {
        border: none;
        margin-bottom: 1.5rem;
    }

    .topic-card .card-header {
        border-bottom: 1px solid rgba(0,0,0,.1);
        background-color: rgba(0,0,0,.02);
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 1em;
    }

    .subtopic-list {
        padding-left: 0;
    }

    .activity-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0,0,0,.05);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .topics-carousel {
        margin: 0 -0.5rem;
    }

    .topics-carousel .col-md-6 {
        padding: 0 0.5rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #4b38b3 0%, #6f42c1 100%);
    }

    .topic-card {
        border: none;
        border-radius: 0.75rem;
        overflow: hidden;
    }

    .topic-card .card-header {
        padding: 1.25rem;
        border: none;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activity-item {
        padding: 0.75rem 1rem;
        margin-bottom: 0.5rem;
        border-radius: 0.5rem;
        background: rgba(0,0,0,.02);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: rgba(0,0,0,.04);
        transform: translateX(5px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .activity-title {
        font-weight: 500;
    }

    .overflow-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,.2) transparent;
    }

    .overflow-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-auto::-webkit-scrollbar-track {
        background: transparent;
    }

    .overflow-auto::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,.2);
        border-radius: 3px;
    }

    /* Dark mode adjustments */
    @media (prefers-color-scheme: dark) {
        .activity-item {
            background: rgba(255,255,255,0.05) !important;
        }
        .activity-item:hover {
            background: rgba(255,255,255,0.08) !important;
        }
        .activity-item span {
            color: rgba(255,255,255,0.9) !important;
        }
        .badge {
            background: rgba(255,255,255,0.1) !important;
        }

        .activity-item[data-color="primary"] {
            background: rgba(75, 56, 179, 0.15) !important;
        }
        .activity-item[data-color="primary"] .activity-title,
        .activity-item[data-color="primary"] .badge {
            color: #a195d6 !important;
        }

        .activity-item[data-color="success"] {
            background: rgba(25, 135, 84, 0.15) !important;
        }
        .activity-item[data-color="success"] .activity-title,
        .activity-item[data-color="success"] .badge {
            color: #75b798 !important;
        }

        .activity-item[data-color="warning"] {
            background: rgba(255, 193, 7, 0.15) !important;
        }
        .activity-item[data-color="warning"] .activity-title,
        .activity-item[data-color="warning"] .badge {
            color: #ffda6a !important;
        }

        .activity-item[data-color="info"] {
            background: rgba(13, 202, 240, 0.15) !important;
        }
        .activity-item[data-color="info"] .activity-title,
        .activity-item[data-color="info"] .badge {
            color: #6edff6 !important;
        }

        .activity-item[data-color="secondary"] {
            background: rgba(108, 117, 125, 0.15) !important;
        }
        .activity-item[data-color="secondary"] .activity-title,
        .activity-item[data-color="secondary"] .badge {
            color: #a7acb1 !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('student.subjects.index') }}" class="btn btn-soft-primary">
                <i class="las la-arrow-left me-2"></i>Back to Subjects
            </a>
        </div>
    </div>

    <!-- Subject Header -->
    <div class="subject-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2>{{ $subject->name }}</h2>
                <div class="meta-info">
                    <span class="me-3"><i class="las la-code me-1"></i>{{ $subject->code }}</span>
                    <span class="me-3"><i class="las la-graduation-cap me-1"></i>{{ $subject->level }}</span>
                    <span><i class="las la-star me-1"></i>{{ $subject->credits }} Credits</span>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                @if($subject->pdf_link)
                <a href="{{ route('student.subjects.pdf', $subject) }}" 
                   class="btn btn-light" target="_blank">
                    <i class="las la-file-pdf me-1"></i>View Course Material
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Subject Details Cards -->
    <div class="row">
        <!-- Description Card -->
        <div class="col-lg-8 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="info-icon bg-soft-primary">
                        <i class="las la-info-circle text-primary"></i>
                    </div>
                    <h5 class="card-title">Description</h5>
                    <p class="text-muted">
                        {{ $subject->description ?? 'No description available.' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="col-lg-4 mb-4">
            <div class="card info-card">
            <div class="card-body">
                <div class="info-icon bg-soft-success">
                <i class="las la-graduation-cap text-success"></i>
                </div>
                <h5 class="card-title">Quick Information</h5>
                <div class="mt-4">
                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded" 
                     style="background: rgba(75, 56, 179, 0.1);">
                    <div class="d-flex align-items-center">
                    <i class="las la-code text-primary me-2"></i>
                    <span class="text-muted">Subject Code</span>
                    </div>
                    <span class="fw-medium text-primary">{{ $subject->code }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                     style="background: rgba(25, 135, 84, 0.1);">
                    <div class="d-flex align-items-center">
                    <i class="las la-star text-success me-2"></i>
                    <span class="text-muted">Credits</span>
                    </div>
                    <span class="fw-medium text-success">{{ $subject->credits }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                     style="background: rgba(13, 202, 240, 0.1);">
                    <div class="d-flex align-items-center">
                    <i class="las la-layer-group text-info me-2"></i>
                    <span class="text-muted">Level</span>
                    </div>
                    <span class="fw-medium text-info">{{ $subject->level }}</span>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!-- Topics and Activities Section -->
        <div class="col-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <div class="info-icon bg-soft-warning me-3">
                                <i class="las la-book text-warning"></i>
                            </div>
                            <h5 class="card-title mb-0">Topics and Activities</h5>
                        </div>
                    </div>

                    @php
                        $topics = $subject->topics()
                            ->where('class_level', 'Primary ' . filter_var($subject->level, FILTER_SANITIZE_NUMBER_INT))
                            ->with(['subtopics', 'activities'])
                            ->get();
                    @endphp

                    @if($topics->count() > 0)
                        <div class="topics-carousel">
                            <div class="row flex-nowrap overflow-auto pb-3" style="scroll-behavior: smooth;">
                                @foreach($topics as $topic)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card topic-card shadow-sm h-100">
                                            <div class="card-header bg-soft-primary">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <h6 class="mb-0 fw-bold text-primary">{{ $topic->name }}</h6>
                                                    <span class="badge bg-primary">
                                                        <i class="las la-clock me-1"></i>
                                                        {{ $topic->duration }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @if($topic->subtopics->count() > 0)
                                                    <div class="mb-4">
                                                        <h6 class="text-success mb-3">
                                                            <i class="las la-list-ul me-2"></i>Subtopics
                                                        </h6>
                                                        <ul class="list-group subtopic-list">
                                                            @foreach($topic->subtopics as $subtopic)
                                                                <li class="list-group-item border-0 ps-0 py-1">
                                                                    <i class="las la-check-circle text-success me-2"></i>
                                                                    {{ $subtopic->name }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                @if($topic->activities->count() > 0)
                                                    <div>
                                                        <h6 class="text-success mb-3">
                                                            <i class="las la-tasks me-2"></i>Activities
                                                        </h6>
                                                        <div class="activities-list">
                                                            @foreach($topic->activities as $key => $activity)
                                                                @php
                                                                    $colors = [
                                                                        'primary' => [
                                                                            'bg' => 'rgba(75, 56, 179, 0.1)',
                                                                            'text' => '#4b38b3',
                                                                            'hover' => 'rgba(75, 56, 179, 0.15)'
                                                                        ],
                                                                        'success' => [
                                                                            'bg' => 'rgba(25, 135, 84, 0.1)',
                                                                            'text' => '#198754',
                                                                            'hover' => 'rgba(25, 135, 84, 0.15)'
                                                                        ],
                                                                        'warning' => [
                                                                            'bg' => 'rgba(255, 193, 7, 0.1)',
                                                                            'text' => '#997404',
                                                                            'hover' => 'rgba(255, 193, 7, 0.15)'
                                                                        ],
                                                                        'info' => [
                                                                            'bg' => 'rgba(13, 202, 240, 0.1)',
                                                                            'text' => '#087990',
                                                                            'hover' => 'rgba(13, 202, 240, 0.15)'
                                                                        ],
                                                                        'secondary' => [
                                                                            'bg' => 'rgba(108, 117, 125, 0.1)',
                                                                            'text' => '#6c757d',
                                                                            'hover' => 'rgba(108, 117, 125, 0.15)'
                                                                        ]
                                                                    ];
                                                                    $colorKey = array_keys($colors)[$key % count($colors)];
                                                                    $color = $colors[$colorKey];
                                                                @endphp
                                                                <div class="activity-item" 
                                                                     style="background-color: {{ $color['bg'] }};"
                                                                     data-color="{{ $colorKey }}">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="activity-icon me-3" 
                                                                             style="background-color: {{ $color['bg'] }}">
                                                                            <i class="las la-tasks" 
                                                                               style="color: {{ $color['text'] }}"></i>
                                                                        </div>
                                                                        <div>
                                                                            <span class="badge activity-badge me-2" 
                                                                                  style="background-color: {{ $color['bg'] }}; color: {{ $color['text'] }}">
                                                                                {{ $activity->type }}
                                                                            </span>
                                                                            <span class="activity-title" 
                                                                                  style="color: {{ $color['text'] }}">
                                                                                {{ $activity->title }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-3">
                            <i class="las la-info-circle me-2"></i>
                            No topics have been added for this subject yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Course Material Card -->
        @if($subject->pdf_link)
        <div class="col-12 mb-4">
            <div class="card info-card">
                <div class="card-body">
                    <div class="info-icon bg-soft-danger">
                        <i class="las la-file-pdf text-danger"></i>
                    </div>
                    <h5 class="card-title">Course Material</h5>
                    <p class="text-muted mb-4">Access your course material in PDF format.</p>
                    <a href="{{ route('student.subjects.pdf', $subject) }}" 
                       class="btn btn-soft-danger"
                       target="_blank">
                        <i class="las la-file-pdf me-1"></i>View PDF
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<style>
    .bg-soft-warning {
        background-color: rgba(255, 199, 0, 0.1);
    }
    
    .bg-soft-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    
    .card .shadow-sm {
        transition: all 0.3s ease;
    }
    
    .card .shadow-sm:hover {
        transform: translateY(-3px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .list-group-item {
        background: transparent;
    }
</style>
@endsection