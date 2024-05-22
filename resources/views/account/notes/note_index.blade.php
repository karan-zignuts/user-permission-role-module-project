@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1 class="mb-4">Notes</h1>
        {{-- create new note button --}}
        @if ($createBtn)
            <a href="{{ route('notes.create') }}" class="btn btn-primary mb-3">Create New</a>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm mb-3">
                    {{-- seach notes --}}
                    <form action="{{ route('notes.index') }}" method="GET" class="d-flex">
                        <input type="text" class="form-control mr-3" id="search" name="search"
                            placeholder="Search by notes name" value="{{ request()->input('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($notes as $note)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $note->name }}</h5>
                            <div class="card-body">
                                <div class="card-content" style="overflow: hidden; max-height: 300px;">
                                    <p>{{ Str::limit($note->description, 200) }}</p>
                                </div>
                            </div>
                            {{-- access edit and delete button if admin give permission --}}
                            <div class="d-flex justify-content-end">
                                @if ($editBtn)
                                    <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-sm btn-primary me-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                @if ($deleteBtn)
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $note->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @foreach ($notes as $note)
            {{-- check user authentication  --}}
            @if (Auth::check() && Auth::id() == $note->user_id)
                <div class="modal fade" id="deleteModal{{ $note->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel{{ $note->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel{{ $note->id }}">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete {{ $note->name }}?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        {{-- pagination --}}
        <div id="pagination" class="pt-2">
            {{ $notes->links() }}
        </div>
    </div>
@endsection
