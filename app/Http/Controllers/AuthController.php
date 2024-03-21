<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Validator;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $request->validate([
      'name' => 'required|string',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|',
      'c_password' => 'required|same:password',
    ]);

    $user = new User([
      'name' => $request->name,
      'email' => $request->email,
      'password' => bcrypt($request->password),
    ]);

    if ($user->save()) {
      return response()->json(
        [
          'message' => 'Successfully created user!',
        ],
        201
      );
    } else {
      return response()->json(['error' => 'Provide proper details']);
    }
  }

  public function login(Request $request)
  {

    $request->validate([
      'email' => 'required|string|email',
      'password' => 'required|string',
      'remember_me' => 'boolean',
    ]);

    $credentials = request(['email', 'password']);
    if (!Auth::attempt($credentials)) {
      return response()->json(
        [
          'message' => 'Unauthorized',
        ],
        401
      );
    }

    $user = $request->user();
    $tokenResult = $user->createToken('Personal Access Token');
    $token = $tokenResult->plainTextToken;

    return response()->json([
      'access_token' => $token,
      'token_type' => 'Bearer',
    ]);
  }

  public function user(Request $request)
  {
    $user = Auth::user();
    return response()->json($user);
  }

  public function logout(Request $request)
  {
    $request
      ->user()
      ->tokens()
      ->delete();

    return response()->json([
      'message' => 'Successfully logged out',
    ]);
  }
}


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Auth;

// class AuthController extends Controller
// {
//     public function showLoginForm()
//     {
//         return view('auth.login');
//     }

//     public function login(Request $request)
//     {
//         // Validate the form data
//         $credentials = $request->validate([
//             'email-username' => 'required|string',
//             'password' => 'required|string',
//         ]);

//         // Attempt to log the user in
//         if (Auth::attempt($credentials)) {
//             // Authentication was successful
//             return redirect()->intended('/');
//         } else {
//             // Authentication failed
//             return back()->withInput()->withErrors(['email-username' => 'Invalid credentials']);
//         }
//     }
// }
