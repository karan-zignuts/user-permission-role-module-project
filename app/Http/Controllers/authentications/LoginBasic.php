<?php

// namespace App\Http\Controllers\authentications;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class LoginBasic extends Controller
// {
//   public function index()
//   {
//     $pageConfigs = ['myLayout' => 'blank'];
//     return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
//   }
// }

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
      // dd($request->all());
      // Validate input
      $request->validate([
        'email' => 'required|string',
        'password' => 'required|string',
      ]);
      // dd($request->all());

        // Attempt to authenticate
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            // Authentication successful, redirect to intended page or home
            return redirect()->intended('/');
        } else {
            // Authentication failed, redirect back with error
            return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
        }
    }
}
