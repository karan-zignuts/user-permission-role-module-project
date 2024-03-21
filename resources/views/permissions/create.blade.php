<!-- resources/views/permissions/create.blade.php -->
@php
$configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'Create')

@section('content')
    <!-- Form to create new permission -->
    <h1>Create New Permission</h1>

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
        <!-- Module wise permissions can be added here -->
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
