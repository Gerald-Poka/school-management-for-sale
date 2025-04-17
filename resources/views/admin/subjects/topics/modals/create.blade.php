<div class="modal fade" id="addTopicModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.subjects.topics.store') }}" method="POST" id="addTopicForm">
                @csrf
                <div class="modal-body">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <label class="form-label">Duration</label>
                            <select class="form-select" name="duration" required>
                                <option value="">Select Duration</option>
                                <option value="1 Week">1 Week</option>
                                <option value="2 Weeks">2 Weeks</option>
                                <option value="3 Weeks">3 Weeks</option>
                                <option value="4 Weeks">4 Weeks</option>
                                <option value="1 Month">1 Month</option>
                                <option value="2 Months">2 Months</option>
                                <option value="Term">Term</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subtopics</label>
                        <div id="subtopics-container">
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
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-subtopic">
                            <i class="las la-plus"></i> Add Subtopic
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activities</label>
                        <div id="activities-container">
                            <div class="row mb-2 activity-row">
                                <div class="col-5">
                                    <select class="form-select" name="activities[0][type]" required>
                                        <option value="Assignment">Assignment</option>
                                        <option value="Quiz">Quiz</option>
                                        <option value="Homework">Homework</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="activities[0][title]" placeholder="Activity title" required>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger remove-activity">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info btn-sm" id="add-activity">
                            <i class="las la-plus"></i> Add Activity
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTopicBtn">Save Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission
    const form = document.getElementById('addTopicForm');
    const submitButton = document.getElementById('saveTopicBtn');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitButton.disabled = true;

        // Regular form submission
        this.submit();
    });

    // Add subtopic button handler
    document.getElementById('add-subtopic').addEventListener('click', function() {
        const container = document.getElementById('subtopics-container');
        if (container.children.length < 4) {
            const newRow = `
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
            container.insertAdjacentHTML('beforeend', newRow);
        }
    });

    // Add activity button handler
    document.getElementById('add-activity').addEventListener('click', function() {
        const container = document.getElementById('activities-container');
        const count = container.children.length;
        const newRow = `
            <div class="row mb-2 activity-row">
                <div class="col-5">
                    <select class="form-select" name="activities[${count}][type]" required>
                        <option value="Assignment">Assignment</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Homework">Homework</option>
                    </select>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control" name="activities[${count}][title]" placeholder="Activity title" required>
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-danger remove-activity">
                        <i class="las la-times"></i>
                    </button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newRow);
    });

    // Remove button handlers
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