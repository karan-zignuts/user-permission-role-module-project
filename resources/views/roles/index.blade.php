@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h3>Roles</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">Create New Role</a>
                        <form action="{{ route('roles.index') }}" method="GET" class="mb-4">
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
                                            {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active</option>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-role-id="{{ $role->id }}"
                                                    id="flexSwitchCheck{{ $role->id }}"
                                                    {{ $role->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck{{ $role->id }}"></label>
                                            </div>
                                        </td>

                                        <td>
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                            <form id="deleteRoleForm{{ $role->id }}"
                                                action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-role-btn"
                                                    data-role-id="{{ $role->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div id="pagination" class="pt-2">
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var roleId = $(this).data('role-id');
                var status = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    url: "{{ route('roles.updateStatus') }}",
                    method: 'POST',
                    data: {
                        role_id: roleId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-role-btn').click(function(e) {
                e.preventDefault();
                var roleId = $(this).data('role-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#deleteRoleForm' + roleId).submit();
                    }
                });
            });
        });
    </script>
@endsection
