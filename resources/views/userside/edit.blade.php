@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
<div class="container">
  <div class="card">
      <div class="card-header">
          <h2 class="card-title">Edit User Details</h2>
      </div>
      <div class="card-body">
          <form method="POST" action="{{ route('userside.update') }}">
              @csrf
              <div class="mb-3">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->first_name }}">
              </div>
              <div class="mb-3">
                  <label for="contact_no" class="form-label">Contact No</label>
                  <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $user->phone_number }}">
              </div>
              <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="4">{{ $user->address }}</textarea>
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


