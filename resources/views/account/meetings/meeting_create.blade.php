@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

{{-- @section('content')
    <form action="{{ route('meetings.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name">
        <input type="text" name="description" placeholder="Description">
        <input type="date" name="date" min="{{ now()->toDateString() }}">
        <input type="time" name="time" min="{{ now()->toTimeString() }}">
        <button type="submit">Save</button>
        <a href="{{ route('meetings.index') }}">Cancel</a>
    </form>
@endsection --}}



@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create New Meeting') }}</div>

                    <div class="card-body">
                        <form action="{{ route('meetings.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    min="{{ now()->toDateString() }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" value="12:30:00"
                                    required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('meetings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
