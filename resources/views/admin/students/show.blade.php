@extends('layouts.master')
@section('title') Student Details @endsection
@section('content')

@component('components.breadcrumb')
    @slot('li_1') Students @endslot
    @slot('title') Student Details @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            @if($student->profile_picture)
                                <img src="{{ Storage::url($student->profile_picture) }}" 
                                     alt="Profile Picture"
                                     class="rounded-circle img-thumbnail"
                                     style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 200px; height: 200px; font-size: 64px;">
                                    {{ substr($student->first_name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4 class="card-title mb-4">Student Information</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-4">
                                    <tbody>
                                        <tr>
                                            <th width="200">Admission Number</th>
                                            <td>{{ $student->admission_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Full Name</th>
                                            <td>{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Class</th>
                                            <td>{{ $student->academicLevel->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ucfirst($student->gender) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $student->date_of_birth->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Admission</th>
                                            <td>{{ $student->date_of_admission->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Special Needs</th>
                                            <td>{{ $student->special_needs ?: 'None' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge bg-{{ $student->is_active ? 'success' : 'danger' }}">
                                                    {{ $student->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <h4 class="card-title mb-4">Guardian Information</h4>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th width="200">Full Name</th>
                                            <td>{{ $student->guardian->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Relationship</th>
                                            <td>{{ ucfirst($student->guardian->relationship) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Primary Phone</th>
                                            <td>{{ $student->guardian->primary_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alternative Phone</th>
                                            <td>{{ $student->guardian->alternative_phone ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $student->guardian->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation</th>
                                            <td>{{ $student->guardian->occupation ?: '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Residential Address</th>
                                            <td>{{ $student->guardian->residential_address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Back to List</a>
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-primary">Edit Student</a>
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