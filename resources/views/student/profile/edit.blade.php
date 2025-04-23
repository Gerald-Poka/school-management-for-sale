@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <form action="{{ route('student.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <!-- Add your form fields here -->
        
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection