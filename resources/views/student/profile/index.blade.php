@extends('layouts.master')
@section('title')
    My Profile
@endsection
@section('css')
    <!-- Additional CSS -->
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Student
        @endslot
        @slot('title')
            My Profile
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Student Profile</h4>
                    <div class="card-actions">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary btn-sm">
                            <i class="ri-edit-2-line align-middle me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto mb-3">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('build/images/users/avatar-1.jpg') }}" 
                                         class="rounded-circle avatar-xl img-thumbnail user-profile-image" 
                                         alt="User profile picture">
                                </div>
                                <h5 class="fs-16 mb-1">{{ $user->name }}</h5>
                                <p class="text-muted mb-0">Student</p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Full Name</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td>{{ $user->phone ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Role</th>
                                            <td>{{ ucfirst($user->role) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Joined</th>
                                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Additional Scripts -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
