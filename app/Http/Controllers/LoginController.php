<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  // public function login(Request $request)
  // {
  //   // Validate the form data
  //   $request->validate([
  //     'email-username' => 'required|string',
  //     'password' => 'required|string',
  //   ]);

  //   $loginField = filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

  //   // Attempt to log the user in
  //   $credentials = [
  //     $loginField => $request->input('email-username'),
  //     'password' => $request->input('password'),
  //   ];

  //   if (Auth::attempt($credentials)) {
  //     // Authentication passed...
  //     return redirect()->intended('/dashboard');
  //   }

  //   // If authentication fails, redirect back with error message
  //   return redirect()
  //     ->back()
  //     ->withInput($request->only('email-username'))
  //     ->withErrors([
  //       'email-username' => 'These credentials do not match our records.',
  //     ]);
  // }

  public function login(Request $request)
  {
    // Validate the form data
    $request->validate([
      'email-username' => 'required|string',
      'password' => 'required|string',
    ]);

    $loginField = filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    // Attempt to log the user in
    $credentials = [
      $loginField => $request->input('email-username'),
      'password' => $request->input('password'),
    ];

    if (Auth::attempt($credentials)) {
      // Authentication passed...

      // Check if the email is hardik@gmail.com
      if ($request->input('email-username') === 'hardik@gmail.com') {
        // If it's hardik@gmail.com, redirect to admin dashboard
        return redirect()->intended('/dashboard');
      } else {
        // Otherwise, redirect to user dashboard
        return redirect()->intended('/user/dashboard');
      }
    }

    // If authentication fails, redirect back with error message
    return redirect()
      ->back()
      ->withInput($request->only('email-username'))
      ->withErrors([
        'email-username' => 'These credentials do not match our records.',
      ]);
  }
}
