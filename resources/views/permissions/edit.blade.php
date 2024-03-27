<!-- resources/views/permissions/edit.blade.php -->
@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'Create')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3><b>
                            <div class="card-header">Edit Permission</div>
                        </b></h3>
                    <div class="card-body">
                        <form action="{{ route('permissions.update', $permission->id) }}" method="POST" id="permissionsForm">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ $permission->name }}">
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control">{{ $permission->description }}</textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label>Module-wise Permissions:</label>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>All</th>
                                            <th>Create</th>
                                            <th>Edit</th>
                                            <th>View</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Inside your Blade template -->
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->name }}</td>
                                                <td><input type="checkbox" class="selectAll"
                                                        data-target="module{{ $module->code }}"> Select All</td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][create]"
                                                        class="permissionCheckbox module{{ $module->code }}" value="create"
                                                        {{ $permission->hasPermission($module->code, 'create') ? 'checked' : '' }}>
                                                </td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][edit]"
                                                        class="permissionCheckbox module{{ $module->code }}" value="edit"
                                                        {{ $permission->hasPermission($module->code, 'edit') ? 'checked' : '' }}>
                                                </td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][view]"
                                                        class="permissionCheckbox module{{ $module->code }}" value="view"
                                                        {{ $permission->hasPermission($module->code, 'view') ? 'checked' : '' }}>
                                                </td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][delete]"
                                                        class="permissionCheckbox module{{ $module->code }}" value="delete"
                                                        {{ $permission->hasPermission($module->code, 'delete') ? 'checked' : '' }}>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to handle the "Select All" checkbox
        function handleSelectAll(checkbox) {
            const checkboxes = checkbox.parentElement.parentElement.querySelectorAll('.permissionCheckbox');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
        }

        // Add event listeners to "Select All" checkboxes
        const selectAllCheckboxes = document.querySelectorAll('.selectAll');
        selectAllCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                handleSelectAll(checkbox);
            });
        });
    </script>
@endsection
