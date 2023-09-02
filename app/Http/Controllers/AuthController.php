<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;

class AuthController extends Controller
{
  public function login(LoginUserRequest $request)
  {
    $request->validated($request->only(['email', 'password']));

    if (!Auth::attempt($request->only(['email', 'password']))) {
      return response()->json([
        'message' => 'Credentials do not match'
      ], 401);
    }

    $user = User::where('email', $request->email)->first();
    $roles = $user->roles->pluck('slug')->all();

    return response()->json([
      'user' => new UserResource($user),
      'roles' => $roles,
      'token' => $user->createToken('API', $roles)->plainTextToken
    ]);
  }


  public function register(StoreUserRequest $request)
  {
    $request->validated($request->only(['name', 'email', 'password']));

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    return response()->json([
      'user' => new UserResource($user),
      'token' => $user->createToken('API')->plainTextToken
    ]);
  }

  public function logout()
  {
    Auth::user()->currentAccessToken()->delete();

    return response()->json([
      'message' => 'Successfully logged out and deleted the access token.'
    ]);
  }
}
