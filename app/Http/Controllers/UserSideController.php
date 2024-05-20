<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserSideController extends Controller
{
    // Show user details
    public function show()
    {
        // Get the authenticated user
        $user = Auth::user();
        return view('userside.details', compact('user'));
    }

    // Show edit user details form
    public function edit()
    {
        // Get the authenticated user
        $user = Auth::user();
        return view('userside.edit', compact('user'));
    }

    // Update user details
    public function update(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string',
            'contact_no' => 'required|string',
            'address' => 'required|string',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update the user details
        $user->first_name = $request->input('name');
        $user->phone_number = $request->input('contact_no');
        $user->address = $request->input('address');
        $user->save();

        // Redirect back to the user details page
        return redirect()->route('userside.details')->with('success', 'User details updated successfully.');
    }

    // Show form for changing password
    public function showChangePasswordForm()
    {
        return view('userside.change_password');
    }

    // Change user password
    public function changePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        // Update user's password
        $user->update(['password' => bcrypt($request->password)]);

        // Logout the user
        Auth::guard('web')->logout();

        // Redirect to login page
        return redirect()->route('auth-login-basic')->with('success', 'Password changed successfully. Please login with your new password.');
    }
}
