@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-header">Welcome! Set Your Password</div>

                    {{-- user set password --}}
                    <div class="card-body">
                        <form method="POST" action="{{ route('setpassword') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mt-2">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">Save Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
