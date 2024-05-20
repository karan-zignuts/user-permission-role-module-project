@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Change Password</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('savePassword') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('userside.details') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
