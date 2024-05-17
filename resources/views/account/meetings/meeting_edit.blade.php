@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edit Meeting</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('meetings.update', $meeting) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $meeting->name }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="description">Description:</label>
                        <textarea class="form-control" id="description" name="description">{{ $meeting->description }}</textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date"
                            value="{{ $meeting->date }}" min="{{ now()->toDateString() }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="time">Time:</label>
                        <input type="time" class="form-control" id="time" name="time"
                            value="{{ $meeting->time }}">
                    </div>
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
