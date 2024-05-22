@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Create Role</h3>
                    </div>

                    {{-- create new role and store data --}}
                    <div class="card-body">
                        <form id="createRoleForm" action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" placeholder="Enter role name"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" placeholder="Enter role description" class="form-control"></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <label for="permissions">Permissions:</label>
                                <select id="permissions" name="permissions[]" class="form-control" multiple>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary" id="saveRoleBtn">Save</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
