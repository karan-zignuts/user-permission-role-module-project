<!-- resources/views/permissions/index.blade.php -->
@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'index')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Permissions</h3>
                    </div>
                    <div class="card-body">
                        {{-- <h1 class="mt-5 mb-4">Permissions</h1> --}}
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-4"><i class="fas fa-plus"></i>
                            Create New
                            Permission</a>

                        <form action="{{ route('permissions.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="{{ request()->input('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>
                                            All</option>
                                        <option value="active"
                                            {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive"
                                            {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive mb-2">
                            <table class="table table-striped permissions-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->description }}</td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-class" type="checkbox"
                                                        data-permission-id="{{ $permission->id }}"
                                                        id="flexSwitchCheck{{ $permission->id }}"
                                                        {{ $permission->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheck{{ $permission->id }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('permissions.edit', $permission->id) }}"
                                                    class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                                                <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                    method="POST" class="d-inline" id="deletePermissionForm">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm delete-permission-btn"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination" class="pt-2">
                            {{ $permissions->appends(request()->query())->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var permission_id = $(this).data('permission-id');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{{ route('permissions.toggleStatus', ':permission_id') }}'.replace(
                        ':permission_id', permission_id),
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'status': status,
                        'permission_id': permission_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-permission-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent the form from submitting

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this permission!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If user confirms, submit the form
                            document.getElementById('deletePermissionForm').submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
