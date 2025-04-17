@extends('layouts.master')
@section('title') My Timetable @endsection

@section('css')
<style>
    .timetable-cell {
        min-height: 100px;
        transition: all 0.3s ease;
    }
    .timetable-cell:hover {
        background-color: rgba(75, 56, 179, 0.05);
    }
    .period-cell {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    .break-cell {
        background-color: #fff3cd;
    }
    .lunch-cell {
        background-color: #d1e7dd;
    }
    .time-column {
        width: 120px;
    }
    .subject-name {
        font-weight: 600;
        color: #4b38b3;
    }
    .teacher-name {
        font-size: 0.875rem;
        color: #6c757d;
    }
    .room-number {
        font-size: 0.75rem;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">My Timetable</h4>
                <div class="page-title-right">
                    <span class="text-muted">
                        {{ auth()->user()->student->academicLevel->name ?? 'Unknown Level' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($timetable)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="time-column">Time</th>
                                        @foreach($days as $day)
                                            <th class="text-center">{{ $day }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($timeSlots as $timeSlot)
                                        <tr>
                                            <td class="align-middle">
                                                {{ $timeSlot[0] }} - {{ $timeSlot[1] }}
                                            </td>
                                            @foreach($days as $day)
                                                @php
                                                    $slot = $timetable->slots
                                                        ->where('day_of_week', $day)
                                                        ->where('start_time', $timeSlot[0])
                                                        ->first();
                                                @endphp
                                                <td class="timetable-cell align-middle {{ $slot && $slot->type !== 'class' ? $slot->type.'-cell' : '' }}">
                                                    @if($slot)
                                                        @if($slot->type === 'class' && $slot->subject)
                                                            <div class="period-cell p-2">
                                                                <div class="subject-name">
                                                                    {{ $slot->subject->name }}
                                                                </div>
                                                                @if($slot->teacher)
                                                                    <div class="teacher-name">
                                                                        {{ $slot->teacher->first_name }} {{ $slot->teacher->last_name }}
                                                                    </div>
                                                                @endif
                                                                @if($slot->room_number)
                                                                    <div class="room-number">
                                                                        Room: {{ $slot->room_number }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="text-center">
                                                                <strong>{{ ucfirst($slot->type) }}</strong>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary text-primary display-5 rounded-circle">
                                    <i class="las la-calendar"></i>
                                </div>
                            </div>
                            <h5>No Timetable Available</h5>
                            <p class="text-muted">
                                The timetable for your academic level has not been published yet.
                            </p>
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
@endsection