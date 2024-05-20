@extends('layouts/layoutMaster')

@section('content')

<form method="POST" action="{{ route('auth.register') }}">
  @csrf
  <input type="text" name="name" placeholder="Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="password" name="c_password" placeholder="Confirm Password" required>
  <button type="submit">Register</button>
</form>

@endsection
