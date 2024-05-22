@php
    $configData = Helper::appClasses();
@endphp
@extends('../layouts/layoutMaster')

@section('title', 'module')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Module</h4>
                </div>
                {{-- edit modules --}}
                <div class="card-body">
                    <form action="{{ route('modules.update', $module) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="name" class="mb-1">Name:</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $module->name) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="description" class="mb-1">Description:</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description', $module->description) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
