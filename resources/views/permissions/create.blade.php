<!-- resources/views/permissions/create.blade.php -->
@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'Create')

{{-- @section('content')
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
@endsection --}}

{{-- @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Create New Permission</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permissions.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <!-- Module wise permissions -->
                            <div class="form-group">
                                <label for="modules">Module-wise Permissions:</label>
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
                                        @foreach ($modules as $module)
                                        <tr>
                                            <td>{{ $module->name }}</td>
                                            <td><input type="checkbox" class="select-all" data-target="{{ $module->id }}"></td>
                                            <td><input type="checkbox" name="permissions[{{ $module->id }}][create]"></td>
                                            <td><input type="checkbox" name="permissions[{{ $module->id }}][edit]"></td>
                                            <td><input type="checkbox" name="permissions[{{ $module->id }}][view]"></td>
                                            <td><input type="checkbox" name="permissions[{{ $module->id }}][delete]"></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End module wise permissions -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>Create New Permission</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('permissions.store') }}" method="POST" id="createPermissionForm">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                            </div>
                            <!-- Module wise permissions -->
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
                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->name }}</td>
                                                <td><input type="checkbox" class="selectAll"
                                                        data-target="module{{ $module->code }}"> Select All</td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][create]"
                                                        class="permissionCheckbox module{{ $module->code }}"></td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][edit]"
                                                        class="permissionCheckbox module{{ $module->code }}"></td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][view]"
                                                        class="permissionCheckbox module{{ $module->code }}"></td>
                                                <td><input type="checkbox" name="permissions[{{ $module->code }}][delete]"
                                                        class="permissionCheckbox module{{ $module->code }}"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Save</button>
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

        // Function to submit the form
        function submitForm() {
            document.getElementById('permissionsForm').submit();
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
