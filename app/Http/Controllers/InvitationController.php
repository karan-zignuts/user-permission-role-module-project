<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    // This function is used for accepting an invitation from admin to user
    public function acceptInvite($token)
    {
        // Define layout configuration for the view
        $pageConfigs = ['myLayout' => 'blank'];

        // Find the user with the given invitation token or fail if not found
        $user = User::where('invitation_token', $token)->firstOrFail();

        // Return the set password view with the token and page configuration
        return view('set_password', compact('token', 'pageConfigs'));
    }

    // This function is used by the user to set their password
    public function setPassword(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token'    => 'required',
        ]);

        // Find the user with the given invitation token or fail if not found
        $user = User::where('invitation_token', $request->token)->firstOrFail();
        $user->password = bcrypt($request->password);
        $user->invitation_token = null;
        $user->save();

        // Redirect to the login page with a success message
        return redirect()->route('auth-login-basic')->with('success', 'Password set successfully!');
    }
}
