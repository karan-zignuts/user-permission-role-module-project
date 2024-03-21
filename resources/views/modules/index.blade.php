<!-- Display modules -->
@php
$configData = Helper::appClasses();
@endphp

@extends('../layouts/layoutMaster')

{{-- @section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Module Management</h4>
      </div>
      <div class="card-body">
        <!-- Search bar -->
        <form action="{{ route('modules.index') }}" method="GET" class="mb-2">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </div>
        </form>
        <!-- Filter -->
        <form action="{{ route('modules.index') }}" method="GET" class="mb-2">
          <div class="input-group">
            <select name="status" class="form-control">
              <option value="">All Modules</option>
              <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Active Modules</option>
              <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Deactivated Modules</option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Filter</button>
            </div>
          </div>
        </form>
        <!-- Module List -->
        @if($modules->count() > 0)
        <div class="list-group">
          @foreach ($modules as $module)
          <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-0">{{ $module->name }}</h5>
                <p class="mb-0">{{ $module->description }}</p>
              </div>
              <div class="ml-auto">
                <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-primary">Edit</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="alert alert-info" role="alert">
          No modules found.
        </div>
        @endif
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
          {{ $modules->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Module Management</h4>
      </div>
      <div class="card-body">
        <!-- Search bar -->
        <form action="{{ route('modules.index') }}" method="GET" class="mb-2">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
          </div>
        </form>
        <!-- Filter -->
        <form action="{{ route('modules.index') }}" method="GET" class="mb-2">
          <div class="input-group">
            <select name="status" class="form-control">
              <option value="">All </option>
              <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Active </option>
              <option value="0" {{ request('status') == 0 ? 'selected' : '' }}>Deactivated </option>
            </select>
            <div class="input-group-append">
              <button class="btn btn-primary" type="submit">Filter</button>
            </div>
          </div>
        </form>
        <!-- Module List -->
        @if($modules->count() > 0)
        <div class="list-group">
          @foreach ($modules as $module)
          <div class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-0">{{ $module->name }}</h5>
                <p class="mb-0">{{ $module->description }}</p>
              </div>
              <div class="ml-auto">
                <!-- Toggle switch -->
                <input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Deactivated" data-onstyle="success" data-offstyle="danger" {{ $module->is_active ? 'checked' : '' }} data-id="{{ $module->id }}" class="toggle-class">
                <a href="{{ route('modules.edit', $module) }}" class="btn btn-sm btn-primary ml-2">Edit</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="alert alert-info" role="alert">
          No modules found.
        </div>
        @endif
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
          {{ $modules->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<script>

$(function() {
           $('.toggle-class').change(function() {
           var status = $(this).prop('checked') == true ? 1 : 0;
           var product_id = $(this).data('id');
           $.ajax({
               type: "GET",
               dataType: "json",
               url: '/status/update',
               data: {'status': status, 'product_id': product_id},
               success: function(data){
               console.log(data.success)
            }
         });
      })
   });
</script>
