@php
    $configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="card-header">Create New Note</h2>

                    <div class="card-body">
                        <form action="{{ route('notes.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter note name" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" placeholder="Enter note description" rows="4" required></textarea>
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                                <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem aspernatur et illum praesentium distinctio velit rem, eum nemo eligendi eos illo at modi doloremque est blanditiis placeat iure. Perspiciatis, quibusdam. --}}
