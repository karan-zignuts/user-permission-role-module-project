@php
    $configData = Helper::appClasses();
@endphp
@section('title', 'index')

@extends('../layouts/layoutMaster')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Modules</h1>

                {{-- modules search and filter  --}}
                <form action="{{ route('modules.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request()->input('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="all" {{ request()->input('status') == 'all' ? 'selected' : '' }}>All
                                </option>
                                <option value="active" {{ request()->input('status') == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ request()->input('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <div id="accordionExample">
                    @foreach ($modules as $module)
                        <div class="card mb-3">
                            <div class="card-header" id="heading{{ $loop->index }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $loop->index }}" aria-expanded="true"
                                        aria-controls="collapse{{ $loop->index }}">
                                        {{ $module->name }}
                                    </button>
                                </h5>
                            </div>

                            {{-- show modules data in table formate like module, description,status and action button columns --}}
                            <div id="collapse{{ $loop->index }}" class="collapse"
                                aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">
                                <div class="card-body">
                                    @if ($module->children->isNotEmpty())
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Module</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($module->children as $subModule)
                                                    <tr>
                                                        <td>{{ $subModule->name }}</td>
                                                        <td>{{ $subModule->description }}</td>
                                                        <td>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input toggle-class" type="checkbox"
                                                                    data-module-id="{{ $subModule->code }}"
                                                                    id="flexSwitchCheck{{ $subModule->code }}"
                                                                    {{ $subModule->is_active ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="flexSwitchCheck{{ $subModule->code }}"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="float-right">
                                                                <a href="{{ route('modules.edit', $subModule) }}"
                                                                    class="btn btn-sm btn-primary ml-2">Edit</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>No sub-modules found.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.toggle-class').change(function() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var submoduleId = $(this).data('module-id');
                var status = $(this).prop('checked') == true ? 1 : 0;
                $.ajax({
                    type: "PUT",
                    dataType: "json",
                    url: '{{ route('modules.toggleStatus', ':submoduleId') }}'.replace(
                        ':submoduleId', submoduleId),
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'status': status,
                        'submoduleId': submoduleId
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            });
        });
    </script>
@endsection
