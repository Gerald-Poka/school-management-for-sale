@extends('layouts.master')
@section('title') Create Subject @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Subjects @endslot
    @slot('title') Create Subject @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.subjects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Level</label>
                                <select class="form-select @error('level') is-invalid @enderror" 
                                        name="level" 
                                        id="level-select" 
                                        required>
                                    <option value="">Select Level</option>
                                    @foreach($standards as $standard)
                                        <option value="{{ $standard }}">{{ $standard }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject Name</label>
                                <select class="form-select @error('name') is-invalid @enderror" 
                                        name="name" 
                                        id="subject-select" 
                                        required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Subject Code</label>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       id="subject-code" 
                                       name="code" 
                                       value="{{ old('code') }}" 
                                       readonly 
                                       required>
                                <small class="text-muted">Auto-generated based on level and subject</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Credits</label>
                                <input type="number" 
                                       class="form-control" 
                                       name="credits" 
                                       value="{{ old('credits', 0) }}" 
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" 
                                     name="description" 
                                     rows="4">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">PDF Book</label>
                            <input type="file" 
                                   class="form-control" 
                                   name="pdf_link" 
                                   accept=".pdf">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
const subjects = @json($subjects);

function generateSubjectCode(subjectName, level) {
    // Extract standard number from level
    const standardNum = level.match(/\d+/)[0];
    
    // Get first letters of each word in subject name
    const nameCode = subjectName
        .split(' ')
        .map(word => word.charAt(0).toUpperCase())
        .join('');

    // Generate random 2-digit number
    const randomNum = Math.floor(Math.random() * 90 + 10);

    // Return formatted code
    return `STD${standardNum}${nameCode}${randomNum}`;
}

document.getElementById('level-select').addEventListener('change', function() {
    const level = this.value;
    const subjectSelect = document.getElementById('subject-select');
    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
    
    if (level && subjects[level]) {
        subjects[level].forEach(subject => {
            const option = new Option(subject, subject);
            subjectSelect.add(option);
        });
    }
    
    // Clear subject code when level changes
    document.getElementById('subject-code').value = '';
});

document.getElementById('subject-select').addEventListener('change', function() {
    const subjectName = this.value;
    const level = document.getElementById('level-select').value;
    
    if (subjectName && level) {
        const code = generateSubjectCode(subjectName, level);
        document.getElementById('subject-code').value = code;
    }
});
</script>
@endsection