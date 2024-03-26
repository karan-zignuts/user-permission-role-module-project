<!-- resources/views/permissions/index.blade.php -->
@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'index')

@section('content')

    <div class="container">
        <h1 class="mt-5 mb-4">Permissions</h1>
        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-4"><i class="fas fa-plus"></i> Create New
            Permission</a>

        <form action="{{ route('permissions.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search..."
                        value="{{ request()->input('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active
                        </option>
                        <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>Inactive
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
                                        data-permission-id="{{ $permission->id }}" id="flexSwitchCheck{{ $permission->id }}"
                                        {{ $permission->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheck{{ $permission->id }}"></label>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm"><i
                                        class="fas fa-edit"></i> </a>
                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this permission?')"><i
                                            class="fas fa-trash-alt"></i> </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $permissions->appends(request()->query())->links() }}
    </div>
    <script>
      $(document).ready(function () {
          // Get the CSRF token value from the meta tag
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

          $('.toggle-class').change(function () {
              var status = $(this).prop('checked') == true ? 1 : 0;
              var permission_id = $(this).data('permission-id');

              $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: '{{ route('permissions.toggleStatus', ':permission_id') }}'.replace(':permission_id', permission_id),
                  // Include the CSRF token in the request headers
                  headers: {
                      'X-CSRF-TOKEN': CSRF_TOKEN
                  },
                  data: {'status': status, 'permission_id': permission_id},
                  success: function (data) {
                      console.log(data.success)
                  }
              });
          });
      });
  </script>

@endsection
