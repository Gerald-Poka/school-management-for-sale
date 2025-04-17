@extends('layouts.master')
@section('title') Schedule Details @endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') Teaching Schedules @endslot
    @slot('title') Schedule Details @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="200">Teacher</th>
                                    <td>{{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Subject</th>
                                    <td>{{ $schedule->subject->name }}</td>
                                </tr>
                                <tr>
                                    <th>Academic Level</th>
                                    <td>{{ $schedule->academicLevel->name }}</td>
                                </tr>
                                <tr>
                                    <th>Day</th>
                                    <td>{{ $schedule->day_of_week }}</td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td>{{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }}</td>
                                </tr>
                                <tr>
                                    <th>Room</th>
                                    <td>{{ $schedule->room_number }} (Wing {{ $schedule->wing }})</td>
                                </tr>
                                <tr>
                                    <th>Academic Year</th>
                                    <td>{{ $schedule->academic_year }}</td>
                                </tr>
                                <tr>
                                    <th>Term</th>
                                    <td>{{ $schedule->term }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.teachers.schedules.index') }}" class="btn btn-secondary">Back to List</a>
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