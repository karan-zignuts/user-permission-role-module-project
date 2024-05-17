@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">People</h1>
                @if ($createBtn)
                    <a href="{{ route('people.create') }}" class="btn btn-primary">Create New</a>
                @endif
            </div>

            <div class="card-body">
                <!-- Search Bar -->
                <form action="{{ route('people.index') }}" method="GET" class="mb-4">
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
                <!-- People List -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Address</th>
                                <th>Status</th>
                                @if ($editBtn || $deleteBtn)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($people as $person)
                                @if (Auth::check() && Auth::id() == $person->user_id)
                                    <tr>
                                        <td>{{ $person->name }}</td>
                                        <td>{{ $person->designation }}</td>
                                        <td>{{ $person->address }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-class" type="checkbox"
                                                    data-person-id="{{ $person->id }}"
                                                    id="flexSwitchCheck{{ $person->id }}"
                                                    {{ $person->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="flexSwitchCheck{{ $person->id }}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($editBtn || $deleteBtn)
                                                @if ($editBtn)
                                                    <a href="{{ route('people.edit', $person->id) }}"
                                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
                                                @endif

                                                @if ($deleteBtn)
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $person->id }}"><i
                                                            class="fas fa-trash-alt"></i> </button>
                                                    <div class="modal fade" id="deleteModal{{ $person->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteModalLabel{{ $person->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteModalLabel{{ $person->id }}">
                                                                        Confirm Delete</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete {{ $person->name }}?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('people.destroy', $person->id) }}"
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
                    <div id="pagination" class="pt-2">
                        {{ $people->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var personId = $(this).data('person-id');
                var status = $(this).prop('checked') ? 1 : 0;

                $.ajax({
                    url: "{{ route('people.updateStatus') }}",
                    method: 'POST',
                    data: {
                        person_id: personId,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                    },
                    error: function(xhr) {
                        // Handle error response
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
