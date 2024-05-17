<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserSideController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('userside.details', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('userside.edit', compact('user'));
    }

    // public function update(Request $request)
    // {
    //   $user = Auth::user();
    //   $user->update($request->only('name', 'contact_no', 'address'));
    //   return redirect()
    //     ->route('userside.details')
    //     ->with('success', 'User details updated successfully!');
    // }
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
    public function showChangePasswordForm()
    {
        return view('userside.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update(['password' => bcrypt($request->password)]);

        Auth::guard('web')->logout();

        return redirect()->route('auth-login-basic')->with('success', 'Password changed successfully. Please login with your new password.');
    }
}


