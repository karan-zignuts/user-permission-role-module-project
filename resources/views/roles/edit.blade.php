@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')
{{-- @section('content')
<form action="{{ route('roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="text" name="name" value="{{ $role->name }}">
    <textarea name="description">{{ $role->description }}</textarea>
    <input type="checkbox" name="active" {{ $role->active ? 'checked' : '' }}>
    <button type="submit">Update</button>
</form>
@endsection --}}

@section('content')
    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Role</div>
                    <div class="card-body">
                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" value="{{ $role->name }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <input type="text" id="description" name="description" value="{{ $role->description }}" class="form-control">
                            </div>
                            <!-- Add permissions selection if needed -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Create Role</div>
                  <div class="card-body">
                      <form action="{{ route('roles.store') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="name">Name:</label>
                              <input type="text" id="name" name="name" placeholder="Enter role name" class="form-control">
                          </div>
                          <div class="form-group">
                              <label for="description">Description:</label>
                              <input type="text" id="description" name="description" placeholder="Enter role description" class="form-control">
                          </div>
                          <div class="form-group">
                              <label for="permissions">Permissions:</label>
                              <select id="permissions" name="permissions[]" class="form-control" multiple>
                                  <!-- Add options for permissions here -->
                                  <option value="permission1">Permission 1</option>
                                  <option value="permission2">Permission 2</option>
                                  <!-- Add more options as needed -->
                              </select>
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Save</button>
                              <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>


@endsection
