<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
  public function acceptInvite($token)
  {
    $pageConfigs = ['myLayout' => 'blank'];

    $user = User::where('invitation_token', $token)->firstOrFail();
    return view('set_password', compact('token', 'pageConfigs'));
  }

  public function setPassword(Request $request)
  {
      $request->validate([
          'password' => 'required|min:6|confirmed',
          'token' => 'required'
      ]);

      $user = User::where('invitation_token', $request->token)->firstOrFail();
      $user->password = bcrypt($request->password);
      $user->invitation_token = null;
      $user->save();

      return redirect()->route('auth-login-basic')->with('success', 'Password set successfully!');
  }

}
