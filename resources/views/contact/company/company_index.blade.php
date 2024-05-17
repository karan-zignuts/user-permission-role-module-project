@extends('../layouts/layoutMaster')

@section('content')
    <h1>Company List</h1>
    @if ($createBtn)
        <a href="{{ route('companies.create') }}" class="btn btn-success mb-4">Create New</a>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm mb-3">
                <form action="{{ route('companies.index') }}" method="GET" class="d-flex">
                    <input type="text" class="form-control mr-3" id="search" name="search"
                        placeholder="Search by notes name" value="{{ request()->input('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        @forelse ($companies as $company)
            @if (Auth::check() && Auth::id() == $company->user_id)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $company->name }}</h5>
                            <p class="card-text"><strong>Owner:</strong> {{ $company->owner_name }}</p>
                            <p class="card-text"><strong>Address:</strong> {{ $company->address }}</p>
                            <p class="card-text"><strong>Industry:</strong> {{ $company->industry }}</p>

                            <td>
                                @if ($editBtn)
                                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-primary"><i
                                            class="fas fa-edit"></i> </a>
                                @endif

                                @if ($deleteBtn)
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $company->id }}"><i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="deleteModal{{ $company->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel{{ $company->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $company->id }}">
                                                        Confirm Delete</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('companies.destroy', $company->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="col">
                <p>No companies found.</p>
            </div>
        @endforelse
    </div>

    <div id="pagination" class="pt-2">
        {{ $companies->links() }}
    </div>
@endsection



