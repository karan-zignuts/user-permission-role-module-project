@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3>User Management</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div id="successMessage" class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create New User</a>
                        <form action="{{ route('users.index') }}" method="GET" class="mb-4" id="filterForm">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="{{ request()->input('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="status" class="form-control" id="statusFilter">
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

                        <table class="table" id="userTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr data-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @php
                                                $roles = $user->roles;
                                                $rolesCount = $roles->count();
                                                $maxRolesToShow = 3; // Set the maximum number of roles to display without truncation
                                                $truncatedRoles = $roles->slice(0, $maxRolesToShow); // Get the first X roles
                                                $remainingRolesCount = $rolesCount - $maxRolesToShow;
                                            @endphp

                                            @foreach ($truncatedRoles as $role)
                                                {{ $role->name }}
                                                @if (!$loop->last)
                                                    ,
                                                @endif
                                            @endforeach

                                            @if ($remainingRolesCount > 0)
                                                +{{ $remainingRolesCount }}
                                            @endif
                                        </td>

                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-user-status" type="checkbox"
                                                    data-user-id="{{ $user->id }}"
                                                    id="flexSwitchCheckUser{{ $user->id }}"
                                                    {{ $user->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheckUser{{ $user->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                            <form id="deleteForm{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-user-id="{{ $user->id }}"
                                                    data-user-name="{{ $user->first_name }} {{ $user->last_name }}">
                                                    <i class="fas fa-trash-alt"></i> </button>
                                            </form>
                                        </td>
                                        <td>
                                            <button type="button" id="earningReportsId"
                                                class="btn btn-primary btn-icon dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                                                <a href="{{ route('resetPass', $user->id) }}" class="dropdown-item">Reset
                                                    Password</a>

                                                <form action="{{ route('forceLogout', $user->id) }}" method="POST"
                                                    id="forceLogoutForm">
                                                    @csrf
                                                    <button class="dropdown-item" type="submit"
                                                        onclick="return confirm('Are you sure you want to force logout?')">Force
                                                        Logout</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="pagination" class="pt-2">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var filterForm = document.getElementById('filterForm');
            var statusFilter = document.getElementById('statusFilter');
            var userTable = document.getElementById('userTable').getElementsByTagName('tbody')[0]
                .getElementsByTagName('tr');

            filterForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent form submission
                var formData = new FormData(filterForm);
                var search = formData.get('search').toLowerCase();
                var status = formData.get('status');

                Array.from(userTable).forEach(function(row) {
                    var name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
                    var rowStatus = row.dataset.status;

                    if ((search === '' || name.includes(search)) && (status === 'all' ||
                            rowStatus === status)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.toggle-user-status').change(function() {
                var userId = $(this).data('user-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('users.toggle-status') }}",
                    method: 'POST',
                    data: {
                        user_id: userId,
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/sweetalert/dist/sweetalert.css">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const userId = event.target.getAttribute('data-user-id');
                    const userName = event.target.getAttribute('data-user-name');

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
                            console.log('Deleting user:', userId);
                            button.disabled =
                                true;
                            document.getElementById('deleteForm' + userId).submit();
                        } else {
                            console.log('Deletion canceled.'); // Debug message
                        }
                    });
                });
            });
        });
    </script>

    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.remove();
            }
        }, 3000);
    </script>
@endsection
