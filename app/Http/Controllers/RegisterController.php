<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }
  public function showRegistrationForm()
  {
      return view('auth.register');
  }

  // Method to handle form submission and create a new user
  public function register(Request $request)
  {
      // Validate the incoming request data
      $validatedData = $request->validate([
          'username' => 'required|string|unique:users',
          'email' => 'required|email|unique:users',
          'password' => 'required|string|min:6',
          'terms' => 'required|accepted', // Assuming a checkbox for terms acceptance
      ]);

      // Create a new user with the validated data
      $user = User::create([
          'username' => $validatedData['username'],
          'email' => $validatedData['email'],
          'password' => bcrypt($validatedData['password']),
      ]);

      // Optionally, you can log in the user automatically after registration
      auth()->login($user);

      // Redirect the user to the dashboard or any other desired location
      return redirect()->route('dashboard');
  }
}

