<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    // dd('hii');
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
      $userEmail = Auth::user()->email;
      if ($userEmail === 'hardik@gmail.com') {
        return redirect()->route('dashboard');
      } else {
        return redirect()->route('userside.details');
      }
    } else {
      return redirect()
        ->back()
        ->withErrors(['message' => 'Invalid credentials']);
    }
  }
  public function logout()
  {
    
  }
}
