<div class="modal fade" id="editTopicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTopicForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Subject and Name -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Subject</label>
                            <select class="form-select" name="subject_id" required>
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Topic Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>

                    <!-- Class Level -->
                    <div class="mb-3">
                        <label class="form-label">Class Level</label>
                        <select class="form-select" name="class_level" required>
                            <option value="">Select Class Level</option>
                            <option value="Primary 1">Primary 1</option>
                            <option value="Primary 2">Primary 2</option>
                            <option value="Primary 3">Primary 3</option>
                            <option value="Primary 4">Primary 4</option>
                            <option value="Primary 5">Primary 5</option>
                            <option value="Primary 6">Primary 6</option>
                            <option value="Primary 7">Primary 7</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subtopics</label>
                        <div id="edit-subtopics-container">
                            <!-- Subtopics will be loaded dynamically -->
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="edit-add-subtopic">
                            <i class="las la-plus"></i> Add Subtopic
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duration</label>
                        <select class="form-select" name="duration" required>
                            <option value="1 Week">1 Week</option>
                            <option value="2 Weeks">2 Weeks</option>
                            <option value="3 Weeks">3 Weeks</option>
                            <option value="4 Weeks">4 Weeks</option>
                            <option value="1 Month">1 Month</option>
                            <option value="2 Months">2 Months</option>
                            <option value="Term">Term</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activities</label>
                        <div id="edit-activities-container">
                            <!-- Activities will be loaded dynamically -->
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="edit-add-activity">
                            <i class="las la-plus"></i> Add Activity
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editTopicModal');
    
    editModal.addEventListener('show.bs.modal', async function (event) {
        const button = event.relatedTarget;
        const topicId = button.getAttribute('data-topic-id');
        const form = this.querySelector('#editTopicForm');
        
        console.log('Opening edit modal for topic:', topicId); // Debug log
        
        // Set the form action URL
        form.action = `/system/Admin/topics/${topicId}`;

        try {
            // Show loading state
            const modalBody = this.querySelector('.modal-body');
            modalBody.style.opacity = '0.5';

            // Fetch topic data
            const response = await fetch(`/system/Admin/topics/${topicId}/edit`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('Received topic data:', result); // Debug log

            if (result.status === 'success' && result.data) {
                const data = result.data;

                // Populate form fields
                form.querySelector('[name="subject_id"]').value = data.subject_id || '';
                form.querySelector('[name="name"]').value = data.name || '';
                form.querySelector('[name="class_level"]').value = data.class_level || '';
                form.querySelector('[name="duration"]').value = data.duration || '';

                // Load subtopics
                const subtopicsContainer = document.getElementById('edit-subtopics-container');
                subtopicsContainer.innerHTML = '';
                if (data.subtopics && data.subtopics.length > 0) {
                    data.subtopics.forEach(subtopic => {
                        addSubtopicRow(subtopicsContainer, subtopic.name);
                    });
                } else {
                    addSubtopicRow(subtopicsContainer);
                }

                // Load activities
                const activitiesContainer = document.getElementById('edit-activities-container');
                activitiesContainer.innerHTML = '';
                if (data.activities && data.activities.length > 0) {
                    data.activities.forEach((activity, index) => {
                        addActivityRow(activitiesContainer, {
                            type: activity.type,
                            title: activity.title
                        }, index);
                    });
                } else {
                    addActivityRow(activitiesContainer, {}, 0);
                }
            } else {
                throw new Error(result.message || 'Failed to load topic data');
            }
        } catch (error) {
            console.error('Error loading topic:', error);
            alert(`Error loading topic data: ${error.message}`);
        } finally {
            // Remove loading state
            const modalBody = this.querySelector('.modal-body');
            modalBody.style.opacity = '1';
        }
    });

    // Add subtopic row function
    function addSubtopicRow(container, value = '') {
        const row = document.createElement('div');
        row.className = 'row mb-2 subtopic-row';
        row.innerHTML = `
            <div class="col-11">
                <input type="text" class="form-control" name="subtopics[]" value="${value}" placeholder="Enter subtopic name">
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger remove-subtopic">
                    <i class="las la-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    }

    // Add activity row function
    function addActivityRow(container, activity = {}, index) {
        const row = document.createElement('div');
        row.className = 'row mb-2 activity-row';
        row.innerHTML = `
            <div class="col-5">
                <select class="form-select" name="activities[${index}][type]" required>
                    <option value="Assignment" ${activity.type === 'Assignment' ? 'selected' : ''}>Assignment</option>
                    <option value="Quiz" ${activity.type === 'Quiz' ? 'selected' : ''}>Quiz</option>
                    <option value="Homework" ${activity.type === 'Homework' ? 'selected' : ''}>Homework</option>
                </select>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" name="activities[${index}][title]" 
                       value="${activity.title || ''}" placeholder="Activity title" required>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-danger remove-activity">
                    <i class="las la-times"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    }

    // Event listeners for add/remove buttons
    document.getElementById('edit-add-subtopic').addEventListener('click', function() {
        const container = document.getElementById('edit-subtopics-container');
        if (container.children.length < 4) {
            addSubtopicRow(container);
        } else {
            alert('Maximum 4 subtopics allowed');
        }
    });

    document.getElementById('edit-add-activity').addEventListener('click', function() {
        const container = document.getElementById('edit-activities-container');
        addActivityRow(container, {}, container.children.length);
    });

    // Event delegation for remove buttons
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
@endpush