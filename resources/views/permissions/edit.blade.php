<!-- resources/views/permissions/edit.blade.php -->
{{-- @php
$configData = Helper::appClasses();
@endphp --}}

@extends('../layouts/layoutMaster')

@section('title', 'Create')
@section('content')
    <!-- Form to edit permission -->
    <h1>Edit Permission</h1>

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $permission->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control">{{ $permission->description }}</textarea>
        </div>
        <!-- Module wise permissions can be edited here -->
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
