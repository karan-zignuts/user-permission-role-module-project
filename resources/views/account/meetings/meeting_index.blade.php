@php
    $configData = Helper::appClasses();
@endphp
@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
          {{-- create new meeting button --}}
            <div class="card-header">
                <h1 class="card-title">Meeting</h1>
                @if ($createBtn)
                    <a href="{{ route('meetings.create') }}"
                        style="text-decoration: none; background-color: #007bff; color: #fff; padding: 10px; border-radius: 5px;"
                        class="btn btn-primary">Create New</a>
                @endif
            </div>

            <div class="card-body">
              {{-- seach and filter meetings --}}
                <form action="{{ route('meetings.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request()->input('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>
                                    All</option>
                                <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                {{-- show meetings data in table formate like module, description,date,time,status and action button columns --}}
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>description</th>
                                <th>date</th>
                                <th>time</th>
                                <th>Status</th>
                                @if ($editBtn || $deleteBtn)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($meetings as $meeting)
                             {{-- check user authentication  --}}
                                @if (Auth::check() && Auth::id() == $meeting->user_id)
                                    <tr>
                                        <td>{{ $meeting->name }}</td>
                                        <td>{{ $meeting->description }}</td>
                                        <td>{{ $meeting->date }}</td>
                                        <td>{{ $meeting->time }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-meeting-id="{{ $meeting->id }}"
                                                    id="flexSwitchCheck{{ $meeting->id }}"
                                                    {{ $meeting->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck{{ $meeting->id }}"></label>
                                            </div>
                                        </td>
                                        {{-- access edit and delete button if admin give permission --}}
                                        <td>
                                            @if ($editBtn || $deleteBtn)
                                                @if ($editBtn)
                                                    <a href="{{ route('meetings.edit', $meeting->id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                                @endif
                                                @if ($deleteBtn)
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $meeting->id }}"><i
                                                            class="fas fa-trash-alt"></i> </button>
                                                    <div class="modal fade" id="deleteModal{{ $meeting->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $meeting->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $meeting->id }}">
                                                                        Confirm Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('meetings.destroy', $meeting->id) }}"
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
                    {{-- pagination --}}
                    <div id="pagination" class="pt-2">
                        {{ $meetings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var meetingId = $(this).data('meeting-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('meetings.updateStatus') }}",
                    method: 'POST',
                    data: {
                        meeting_id: meetingId,
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
