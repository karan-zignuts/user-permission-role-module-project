@extends('../layouts/layoutMaster')

@section('title', 'module')

@section('content')

<form action="{{ route('modules.update', $module) }}" method="POST">
  @csrf
  @method('PUT')
  <label>Name:</label>
  <input type="text" name="name" value="{{ old('name', $module->name) }}" required>
  <label>Description:</label>
  <textarea name="description">{{ old('description', $module->description) }}</textarea>
  <button type="submit">Update</button>
</form>


@endsection
