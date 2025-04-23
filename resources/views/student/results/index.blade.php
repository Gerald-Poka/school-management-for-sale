@extends('layouts.master')
@section('title') Exam Results @endsection
@section('css')
<style>
    .results-table {
        background: var(--vz-card-bg-custom);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .grade-badge {
        font-size: 0.875rem;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        display: inline-block;
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
    
    .grade-f {
        background-color: rgba(231, 76, 60, 0.1);
        color: #c0392b;
    }
    
    .pending-badge {
        background-color: rgba(241, 196, 15, 0.1);
        color: #f39c12;
        padding: 0.35rem 0.75rem;
        border-radius: 50px;
        font-size: 0.875rem;
    }
    
    .progress {
        width: 100px;
        height: 6px !important;
        margin: 0;
    }
    
    .table > :not(caption) > * > * {
        padding: 1rem 1.25rem;
    }
</style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Student @endslot
        @slot('title') Exam Results @endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($subjects->isEmpty())
                        <div class="text-center p-4">
                            <i class="las la-graduation-cap fs-1 text-muted mb-3"></i>
                            <h5 class="card-title">No Subjects Available</h5>
                            <p class="text-muted">You don't have any subjects registered yet.</p>
                        </div>
                    @else
                        <div class="table-responsive results-table">
                            <table class="table table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-primary">
                                        <th scope="col">Subject</th>
                                        <th scope="col">Exam Type</th>
                                        <th scope="col">Marks</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Progress</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                        @if($subject->results->isEmpty())
                                            <tr>
                                                <td>{{ $subject->name }}</td>
                                                <td colspan="6" class="text-center">
                                                    <div class="pending-badge">
                                                        Results Pending
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach($subject->results as $result)
                                                <tr>
                                                    <td>{{ $subject->name }}</td>
                                                    <td>{{ $result->exam_type }}</td>
                                                    <td>{{ $result->marks_obtained }}%</td>
                                                    <td>
                                                        <span class="grade-badge grade-{{ strtolower($result->grade) }}">
                                                            {{ $result->grade }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" 
                                                                style="width: {{ ($result->marks_obtained) }}%">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $result->exam_date->format('M d, Y') }}</td>
                                                    <td>
                                                        @if($result->remarks)
                                                            <small class="text-muted">{{ $result->remarks }}</small>
                                                        @else
                                                            <small class="text-muted">-</small>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection