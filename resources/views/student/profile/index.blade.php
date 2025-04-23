@extends('layouts.master')
@section('title')
    My Profile
@endsection
@section('css')
<style>
    .profile-wrapper {
        background: linear-gradient(135deg, rgba(75, 56, 179, 0.1) 0%, rgba(75, 56, 179, 0.2) 100%);
        border-radius: 15px;
        overflow: hidden;
        position: relative;
    }
    
    .profile-wrapper::before {
        content: "";
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: rgba(75, 56, 179, 0.1);
        z-index: 0;
    }
    
    .profile-wrapper::after {
        content: "";
        position: absolute;
        bottom: -60px;
        left: -60px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(75, 56, 179, 0.1);
        z-index: 0;
    }

    .profile-header {
        position: relative;
        z-index: 1;
        padding: 2rem;
        background: transparent;
    }

    .profile-picture-container {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    .profile-picture {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .welcome-content {
        position: relative;
        z-index: 1;
    }

    .profile-info-card {
        background: var(--vz-card-bg-custom);
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .profile-info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .info-title {
        color: var(--vz-heading-color);
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .student-status {
        background: rgba(75, 56, 179, 0.1);
        color: #4b38b3;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .edit-button {
        background: #4b38b3;
        color: #fff;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .edit-button:hover {
        background: #3a2d8f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(75, 56, 179, 0.2);
    }

    .modal-content {
        background: var(--vz-card-bg-custom);
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .modal-header {
        background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-header .modal-title {
        color: #fff;
        font-weight: 500;
    }

    .modal-body {
        padding: 2rem;
        background: var(--vz-card-bg-custom);
    }

    .contact-info p {
        font-size: 1.1rem;
        padding: 12px 20px;
        border-radius: 10px;
        background: var(--vz-card-bg-custom);
        border: 1px solid rgba(46, 204, 113, 0.2);
        display: inline-block;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .contact-info p:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .contact-info i {
        font-size: 1.2rem;
        color: #2ecc71;
    }

    .contact-info a {
        color: #2ecc71;
        transition: all 0.3s ease;
    }

    .contact-info a:hover {
        color: #27ae60;
        text-decoration: none !important;
        opacity: 0.9;
    }

    .modal-footer {
        border-top: none;
        padding: 1rem 2rem 2rem;
    }

    .modal-footer .btn-success {
        background: linear-gradient(135deg, #3498db 0%, #2ecc71 100%);
        border: none;
        padding: 0.5rem 2rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .modal-footer .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.2);
    }

    [data-layout-mode="dark"] {
        .modal-content {
            background: var(--vz-card-bg-custom);
        }

        .modal-header {
            background: linear-gradient(135deg, #2980b9 0%, #27ae60 100%);
        }

        .contact-info p {
            background: rgba(46, 204, 113, 0.1);
            border-color: rgba(46, 204, 113, 0.2);
        }

        .contact-info i,
        .contact-info a {
            color: #2ecc71;
        }

        .contact-info span {
            color: var(--vz-body-color);
        }
    }
</style>
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

    <div class="profile-wrapper">
        <div class="profile-header">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <div class="profile-picture-container">
                        @if(auth()->user()->student->profile_picture)
                            <img src="{{ Storage::url(auth()->user()->student->profile_picture) }}" 
                                 class="profile-picture"
                                 alt="Profile Picture">
                        @else
                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-1" 
                                 style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                {{ substr(auth()->user()->student->first_name ?? '', 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="welcome-content">
                        <h3 class="mb-2 fw-semibold">{{ auth()->user()->name }}</h3>
                        <div class="student-status">
                            <i class="ri-user-3-line"></i> Student
                        </div>
                        <p class="text-muted mt-3 mb-4">Welcome to your profile dashboard. Here you can view and manage your personal information.</p>
                        <a href="javascript:void(0);" class="edit-button">
    <i class="ri-edit-2-line align-middle me-1"></i> Edit Profile
</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6">
                    <div class="profile-info-card">
                        <h4 class="info-title">
                            <i class="ri-user-info-line"></i> Personal Information
                        </h4>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 info-table">
                                <tbody>
                                    <tr>
                                        <th>Full Name</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <!-- <tr>
                                        <th>Phone</th>
                                        <td>{{ $user->phone ?? 'Not provided' }}</td>
                                    </tr> -->
                                    <tr>
                                        <th>Joined</th>
                                        <td>{{ $user->created_at->format('d M, Y') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="profile-info-card">
                        <h4 class="info-title">
                            <i class="ri-parent-line"></i> Parent/Guardian Information
                        </h4>
                        @if($student && $student->guardian)
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0 info-table">
                                    <tbody>
                                        <tr>
                                            <th>Guardian Name</th>
                                            <td>{{ $student->guardian->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Relationship</th>
                                            <td>{{ $student->guardian->relationship }}</td>
                                        </tr>
                                        <tr>
                                            <th>Primary Phone</th>
                                            <td>{{ $student->guardian->primary_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $student->guardian->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation</th>
                                            <td>{{ $student->guardian->occupation }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $student->guardian->residential_address }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="ri-information-line me-2"></i>No guardian information available.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="editInfoModalLabel">Profile Modification Notice</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="ri-customer-service-2-line" style="font-size: 3rem; color: #2ecc71;"></i>
                        </div>
                        <p class="text-center mb-4" style="color: var(--vz-body-color);">For any modification of your details, please contact the system administrator:</p>
                        <div class="text-center">
                            <div class="contact-info mb-3">
                                <p class="mb-3">
                                    <i class="ri-phone-line me-2"></i>
                                    <span style="color: var(--vz-body-color);">0673128464</span>
                                </p>
                                <p class="mb-0">
                                    <i class="ri-whatsapp-line me-2"></i>
                                    <a href="https://wa.me/255754318464" class="text-decoration-none">
                                        0754318464
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the edit button
            const editButton = document.querySelector('.edit-button');
            
            // Add click event listener
            editButton.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent the default link behavior
                
                // Show the modal
                var editModal = new bootstrap.Modal(document.getElementById('editInfoModal'));
                editModal.show();
            });
        });
    </script>
@endsection
