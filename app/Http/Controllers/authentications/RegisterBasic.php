<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterBasic extends Controller
{
  public function index()
  {
      $pageConfigs = ['myLayout' => 'blank'];
      return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function register(Request $request)
  {
      // Validate input
      $request->validate([
          'username' => 'required|string',
          'email' => 'required|email|unique:users,email',
          'password' => 'required|string|min:6',
          'terms' => 'required|accepted',
      ]);

      // Create a new user
      $user = new User();
      $user->username = $request->input('username');
      $user->email = $request->input('email');
      $user->password = bcrypt($request->input('password'));
      $user->save();

      // Log in the user
      Auth::login($user);

      // Redirect to the login page
      return redirect()->route('auth-login-basic')->with('success', 'Registration successful!');
  }
}
