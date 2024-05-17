{{-- @php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <h1>Create New Company</h1>

    <form action="{{ route('companies.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
        </div>
        <div class="mb-3">
            <label for="owner_name" class="form-label">Owner's Name</label>
            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Owner's Name">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address">
        </div>
        <div class="mb-3">
            <label for="industry" class="form-label">Industry</label>
            <input type="text" class="form-control" id="industry" name="industry" placeholder="Industry">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection --}}

@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Create New Company</h1>
            </div>
            <div class="card-body">
                {{-- Form to create a new company --}}
                <form action="{{ route('companies.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <label for="owner_name" class="form-label">Owner's Name</label>
                        <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Owner's Name">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                    </div>
                    <div class="mb-3">
                        <label for="industry" class="form-label">Industry</label>
                        <input type="text" class="form-control" id="industry" name="industry" placeholder="Industry">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('companies.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
