@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Active Modules </h5>
                        <p>{{ $totalActiveModules }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Active Permissions</h5>
                        <p>{{ $totalActivePermissions }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Active Roles</h5>
                        <p>{{ $totalActiveRoles }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Active Users</h5>
                        <p>{{ $totalActiveUsers }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
