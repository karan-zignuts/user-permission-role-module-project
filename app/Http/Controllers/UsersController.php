<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Mail\InviteEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    // Show list of all users
    // public function index(Request $request)
    // {
    //     $users = User::paginate(10);
    //     return view('users.index', compact('users'));
    // }

    public function index(Request $request)
    {
        // Get the authenticated user
        $authenticatedUser = auth()->user();

        // Check if the authenticated user is "hardik@gmail.com"
        if ($authenticatedUser->email === 'hardik@gmail.com') {
            // If the user is "hardik@gmail.com",
            // proceed without checking permissions
            $users = User::paginate(10);
        } else {
            // If not, check if the user has permission to view users
            if (!$authenticatedUser->hasPermissionTo('view_users')) {
                abort(403, 'Unauthorized');
            }

            // Proceed with fetching users
            $users = User::paginate(10);
        }

        return view('users.index', compact('users'));
    }

    // Show user creation form
    // public function create()
    // {
    //     $roles = Role::all();
    //     return view('users.create', compact('roles'));
    // }

    public function create()
    {
        // Get the authenticated user's email
        $userEmail = auth()->user()->email;

        // Define the email address that should have special access
        // $allowedEmail = 'hardik@gmail.com';

        // Check if the authenticated user's email matches the allowed email
        if ($userEmail !== 'hardik@gmail.com') {
            abort(403, 'Unauthorized');
        }

        // If the email matches, proceed with creating users
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // public function store(Request $request)
    // {
    //     if (!auth()->user()->hasPermissionTo('create_users')) {
    //         abort(403, 'Unauthorized');
    //     }
    //     // Validate input
    //     $request->validate(
    //         [
    //             'first_name' => 'required|string',
    //             'last_name' => 'required|string',
    //             'email' => 'required|email|unique:users,email',
    //             'roles' => 'required|array',
    //             'contact_no' => 'nullable|string',
    //             'address' => 'nullable|string',
    //         ],
    //         [
    //             'email.unique' => 'The email address is already taken.',
    //         ],
    //     );

    //     // Generate invitation token
    //     $token = Str::random(32); // Generate a random string for the token

    //     // Create user in the database with invitation token
    //     $user = User::create([
    //         'first_name' => $request->first_name,
    //         'last_name' => $request->last_name,
    //         'email' => $request->email,
    //         'phone_number' => $request->contact_no,
    //         'address' => $request->address,
    //         'invitation_token' => $token,
    //     ]);

    //     $user->roles()->attach($request->roles);

    //     // Send invitation email with the invitation token
    //     Mail::to($request->email)->send(new InviteEmail($user, $token));

    //     return redirect()->route('users.index')->with('success', 'User created successfully and invitation email sent.');
    // }

    public function store(Request $request)
    {
        // Get the authenticated user's email
        $userEmail = auth()->user()->email;

        // Define the email address that should have special access
        // $allowedEmail = 'hardik@gmail.com';

        // Check if the authenticated user's email matches the allowed email
        if ($userEmail !== 'hardik@gmail.com') {
            abort(403, 'Unauthorized');
        }

        // If the email matches, proceed with creating users

        // Validate input
        $request->validate(
            [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'roles' => 'required|array',
                'contact_no' => 'nullable|string',
                'address' => 'nullable|string',
            ],
            [
                'email.unique' => 'The email address is already taken.',
            ],
        );

        // Generate invitation token
        $token = Str::random(32); // Generate a random string for the token

        // Create user in the database with invitation token
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->contact_no,
            'address' => $request->address,
            'invitation_token' => $token,
        ]);

        $user->roles()->attach($request->roles);

        // Send invitation email with the invitation token
        Mail::to($request->email)->send(new InviteEmail($user, $token));

        return redirect()->route('users.index')->with('success', 'User created successfully and invitation email sent.');
    }

    // public function edit($id)
    // {
    //     $user = User::findOrFail($id); // Assuming you have a User model
    //     $roles = Role::all(); // Assuming you have a Role model

    //     return view('users.edit', compact('user', 'roles'));
    // }

    public function edit($id)
    {
        // Check if the authenticated user has permission to edit users
        $userEmail = auth()->user()->email;

        // Define the email address that should have special access
        // $allowedEmail = 'hardik@gmail.com';

        // Check if the authenticated user's email matches the allowed email
        if ($userEmail !== 'hardik@gmail.com') {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $userEmail = auth()->user()->email;

        // Define the email address that should have special access
        // $allowedEmail = 'hardik@gmail.com';

        // Check if the authenticated user's email matches the allowed email
        if ($userEmail !== 'hardik@gmail.com') {
            abort(403, 'Unauthorized');
        }
        // Find the user by ID
        $user = User::findOrFail($id);
        // dd($user);

        // Update the user's attributes
        $user->update([
            'first_name' => $request->input('name'),
            'phone_number' => $request->input('contact'),
            'address' => $request->input('address'),
        ]);

        // Sync user roles
        $user->roles()->sync($request->input('role'));

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    // Delete user
    // public function destroy(User $user)
    // {
    //     $user->delete();

    //     return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    // }

    public function destroy(User $user)
    {
        $userEmail = auth()->user()->email;

        // Define the email address that should have special access
        // $allowedEmail = 'hardik@gmail.com';

        // Check if the authenticated user's email matches the allowed email
        if ($userEmail !== 'hardik@gmail.com') {
            abort(403, 'Unauthorized');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleStatus(Request $request)
    {
        // Retrieve user ID and status from the request
        $userId = $request->user_id;
        $status = $request->status;

        // Find the user by ID
        $user = User::findOrFail($userId);

        // Update the user's status
        $user->is_active = $status;
        $user->save();

        // Return a response indicating success or failure
        return response()->json(['success' => true]);
    }

    public function showResetPasswordForm($userId)
    {
        $user = User::findOrFail($userId);
        return view('users.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, $userId)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Validate the request
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Update user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Send email notification
        Mail::to($user->email)->send(new PasswordResetNotification($user));

        return redirect()->back()->with('success', 'Password reset successfully and notification sent to the user.');
    }

    public function forceLogout($userId)
    {
        $user = User::findOrFail($userId);

        // Invalidate all user sessions
        DB::table('users')
            ->where('id', $user->id)
            ->delete();

        return redirect()->route('users.index');
    }
}
