@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            {{-- create new activity log button --}}
            <div class="card-header">
                <h1 class="card-title">Activity Log</h1>
                @if ($createBtn)
                    <a href="{{ route('activities.create') }}"
                        style="text-decoration: none; background-color: #007bff; color: #fff; padding: 10px; border-radius: 5px;"
                        class="btn btn-primary">Create New</a>
                @endif
            </div>

            <div class="card-body">
                {{-- seach and filter activity log --}}
                <form action="{{ route('activities.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request()->input('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>All
                                </option>
                                <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                {{-- show activity log data in table formate like module, description,assign person,status and action button columns --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Assign Person</th>
                                <th>Status</th>
                                @if ($editBtn || $deleteBtn)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                                {{-- check user authentication  --}}
                                @if (Auth::check() && Auth::id() == $activity->user_id)
                                    <tr>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ $activity->assign_person }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-activity-id="{{ $activity->id }}"
                                                    id="flexSwitchCheck{{ $activity->id }}"
                                                    {{ $activity->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck{{ $activity->id }}"></label>
                                            </div>
                                        </td>
                                        {{-- access edit and delete button if admin give permission --}}
                                        <td>
                                            @if ($editBtn || $deleteBtn)
                                                @if ($editBtn)
                                                    <a href="{{ route('activities.edit', $activity->id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                                @endif

                                                @if ($deleteBtn)
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $activity->id }}"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                    <div class="modal fade" id="deleteModal{{ $activity->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $activity->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $activity->id }}">Confirm
                                                                        Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this activity?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('activities.destroy', $activity->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{-- pagination  --}}
                    <div id="pagination" class="pt-2">
                        {{ $activities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var activityId = $(this).data('activity-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('activities.updateStatus') }}",
                    method: 'POST',
                    data: {
                        activity_id: activityId,
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
@endsection
