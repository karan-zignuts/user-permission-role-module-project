@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card my-4">
                    <div class="card-header">
                        <h2 class="card-title text-center">User Details</h2>
                    </div>
                    {{-- show users details  --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <img src="{{ asset('assets/img/avatars/14.png') }}" alt="User Image"
                                    class="d-block img-fluid rounded-circle mb-3">
                            </div>
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Contact No:</strong> {{ $user->phone_number }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Address:</strong> {{ $user->address }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Roles:</strong>

                                            @foreach ($user->roles as $role)
                                                <li class="list-inline-item">{{ $role->name }}</li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <a href="{{ route('userside.edit') }}" class="btn btn-primary btn-block">Edit</a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('changePassword') }}" class="btn btn-primary btn-block">Change
                                    Password</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
