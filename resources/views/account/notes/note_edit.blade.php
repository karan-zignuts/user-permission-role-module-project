@php
    $configData = Helper::appClasses();
@endphp
@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Note</h1>

        <div class="card ">
            <div class="card-body">
                <form action="{{ route('notes.update', $note) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $note->name }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control" style="height: 200px">{{ $note->description }}</textarea>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
