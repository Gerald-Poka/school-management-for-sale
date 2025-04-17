<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.subjects.index') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Name</label>
                        <input type="text" class="form-control" name="name" value="{{ request('name') }}" placeholder="Search by name...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Standard</label>
                        <select class="form-select" name="level">
                            <option value="">All Standards</option>
                            @foreach(['Standard 1', 'Standard 2', 'Standard 3', 'Standard 4', 'Standard 5', 'Standard 6'] as $level)
                                <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Credits</label>
                        <div class="row">
                            <div class="col-6">
                                <input type="number" class="form-control" name="credits_min" 
                                       placeholder="Min Credits" value="{{ request('credits_min') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" name="credits_max" 
                                       placeholder="Max Credits" value="{{ request('credits_max') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Clear Filters</a>
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>
</div>