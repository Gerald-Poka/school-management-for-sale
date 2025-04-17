@extends('layouts.master')
@section('title') Teaching Schedules @endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Teaching @endslot
    @slot('title') Teaching Schedules @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Teaching Schedules</h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <a href="{{ route('admin.teachers.schedules.create') }}" class="btn btn-soft-primary">
                                <i class="ri-add-line align-bottom me-1"></i> Add Schedule
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap table-striped-columns mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Teacher</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Day & Time</th>
                                        <th scope="col">Room</th>
                                        <th scope="col" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->teacher->first_name }} {{ $schedule->teacher->last_name }}</td>
                                            <td>{{ $schedule->subject->name }}</td>
                                            <td>
                                                {{ $schedule->academicLevel->name }}
                                                <div class="badge badge-soft-primary">Wing {{ $schedule->wing }}</div>
                                            </td>
                                            <td>
                                                {{ $schedule->day_of_week }}
                                                <div class="fs-13 text-muted">
                                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                </div>
                                            </td>
                                            <td>Room {{ $schedule->room_number }}</td>
                                            <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="{{ route('admin.teachers.schedules.show', $schedule->id) }}" 
                                                       class="link-info fs-15"
                                                       title="View Details">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <form action="{{ route('admin.teachers.schedules.destroy', $schedule->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="link-danger fs-15 border-0 bg-transparent"
                                                                onclick="return confirm('Are you sure you want to delete this schedule?')">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No schedules found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection