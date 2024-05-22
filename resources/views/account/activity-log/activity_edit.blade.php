@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-header text-white">
                <h1 class="card-title mb-0">Edit Activity</h1>
            </div>
            {{-- edit activity log  --}}
            <div class="card-body">
                <form action="{{ url('/activities/' . $activity->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <b><label for="name" class="form-label">Name</label></b>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $activity->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ $activity->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="assign_person" class="form-label">Assigned Person</label>
                        <input type="text" class="form-control" id="assign_person" name="assign_person"
                            value="{{ $activity->assign_person }}">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary me-md-2">Save</button>
                        <a href="{{ url('/activities') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
