@extends('layouts.master')
@section('title') Topics Management @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subjects @endslot
    @slot('title') Topics Management @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title mb-0 flex-grow-1">Topics List</h5>
                        <button type="button" class="btn btn-light me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="las la-filter"></i> Filter
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                            <i class="las la-plus"></i> Add New Topic
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Add error messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Add success message --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Topic Name</th>
                                    <th>Subject</th>
                                    <th>Duration</th>
                                    <th>Subtopics</th>
                                    <th>Activities</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topics as $topic)
                                <tr>
                                    <td>{{ $topic->name }}</td>
                                    <td>{{ $topic->subject->name }}</td>
                                    <td>{{ $topic->duration }}</td>
                                    <td>{{ $topic->subtopics->count() }}</td>
                                    <td>{{ $topic->activities->count() }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewTopicModal" 
                                                    data-topic-id="{{ $topic->id }}"
                                                    title="View Details">
                                                <i class="las la-eye"></i>
                                            </button>
                                            <!-- <button type="button" 
                                                    class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editTopicModal" 
                                                    data-topic-id="{{ $topic->id }}">
                                                <i class="las la-edit"></i> Edit
                                            </button> -->
                                            <form action="{{ route('admin.subjects.topics.destroy', $topic) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this topic?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete">
                                                    <i class="las la-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No topics found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('admin.subjects.topics.modals.filter')
@include('admin.subjects.topics.modals.create')
@include('admin.subjects.topics.modals.edit')
@include('admin.subjects.topics.modals.view')

@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any active filters
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.toString()) {
        document.querySelector('.btn-light').classList.add('active');
    }

    // View Topic Modal
    const viewTopicModal = document.getElementById('viewTopicModal');
    viewTopicModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const topicId = button.getAttribute('data-topic-id');
        
        // Fetch topic details
        fetch(`/system/Admin/topics/${topicId}`)
            .then(response => response.json())
            .then(data => {
                // Populate modal with topic details
                this.querySelector('.topic-subject').textContent = data.subject.name;
                this.querySelector('.topic-name').textContent = data.name;
                this.querySelector('.topic-duration').textContent = data.duration;

                // Populate subtopics
                const subtopicsList = this.querySelector('.topic-subtopics');
                subtopicsList.innerHTML = data.subtopics
                    .map(subtopic => `<li>${subtopic.name}</li>`)
                    .join('');

                // Populate activities
                const activitiesList = this.querySelector('.topic-activities');
                activitiesList.innerHTML = data.activities
                    .map(activity => `<li>${activity.type}: ${activity.title}</li>`)
                    .join('');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading topic details');
            });
    });

    // Edit Topic Modal
    const editTopicModal = document.getElementById('editTopicModal');
    editTopicModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const topicId = button.getAttribute('data-topic-id');
        // Fetch topic details via AJAX
        fetch(`/admin/subjects/topics/${topicId}/edit`)
            .then(response => response.json())
            .then(data => {
                // Populate form with topic details
                const form = this.querySelector('form');
                form.querySelector('[name="name"]').value = data.name;
                // ...populate other fields
            });
    });

    // Add Topic Form - Subtopics Management
    let subtopicTemplate = `
        <div class="row mb-2 subtopic-row">
            <div class="col-11">
                <input type="text" class="form-control" name="subtopics[]" placeholder="Enter subtopic name" required>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger remove-subtopic">
                    <i class="las la-times"></i>
                </button>
            </div>
        </div>
    `;

    document.getElementById('add-subtopic')?.addEventListener('click', function() {
        const container = document.getElementById('subtopics-container');
        if (container.children.length < 4) {
            container.insertAdjacentHTML('beforeend', subtopicTemplate);
        } else {
            alert('Maximum 4 subtopics allowed');
        }
    });

    // Add Topic Form - Activities Management
    let activityCount = 1;
    document.getElementById('add-activity')?.addEventListener('click', function() {
        const container = document.getElementById('activities-container');
        container.insertAdjacentHTML('beforeend', `
            <div class="row mb-2 activity-row">
                <div class="col-5">
                    <select class="form-select" name="activities[${activityCount}][type]" required>
                        <option value="Assignment">Assignment</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Homework">Homework</option>
                    </select>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" name="activities[${activityCount}][title]" 
                           placeholder="Activity title" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-activity">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
        `);
        activityCount++;
    });

    // Remove buttons functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-subtopic')) {
            e.target.closest('.subtopic-row').remove();
        }
        if (e.target.closest('.remove-activity')) {
            e.target.closest('.activity-row').remove();
        }
    });
});
</script>
@endsection