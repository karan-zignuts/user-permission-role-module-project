<!-- Display modules -->
@php
$configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Module Management</h4>
      </div>
      <div class="card-body">
          <form action="{{ route('modules.index') }}" method="GET" class="mb-4">
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
        <!-- Module List -->
        @if($modules->count() > 0)
          <div class="table-responsive">
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Description</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($modules as $module)
                      <tr>
                          <td>{{ $module->name }}</td>
                          <td>{{ $module->description }}</td>
                          <td>
                              <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-primary ml-2">Edit</a>
                          </td>
                      </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
          @else
          <div class="alert alert-info" role="alert">
              No modules found.
          </div>
          @endif
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
          {{ $modules->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
