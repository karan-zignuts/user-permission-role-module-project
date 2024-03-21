<!-- resources/views/permissions/index.blade.php -->
@php
$configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('title', 'index')

@section('content')

<div class="container">
  <h1 class="mt-5 mb-4">Permissions</h1>
  <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-4"><i class="fas fa-plus"></i> Create New Permission</a>

  <form action="{{ route('permissions.index') }}" method="GET" class="mb-4">
      <div class="row">
          <div class="col-md-4">
              <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request()->input('search') }}">
          </div>
          <div class="col-md-3">
              <select name="status" class="form-control">
                  <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>All</option>
                  <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active</option>
                  <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
              </select>
          </div>
          <div class="col-md-2">
              <button type="submit" class="btn btn-primary">Filter</button>
          </div>
      </div>
  </form>

  <div class="table-responsive">
      <table class="table table-striped">
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
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheck{{ $permission->id }}" {{ $permission->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexSwitchCheck{{ $permission->id }}"></label>
                    </div>
                </td>
                <td>
                    <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i> </a>
                    <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this permission?')"><i class="fas fa-trash-alt"></i> </button>
                    </form>
                </td>
            </tr>
        @endforeach
          </tbody>
      </table>
  </div>

  {{ $permissions->appends(request()->query())->links() }}
</div>


<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>


@endsection
