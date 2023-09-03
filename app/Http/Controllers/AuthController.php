<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

use App\Models\LinkedSocialUser;
use Laravel\Socialite\AbstractUser;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\LoginSocialRequest;


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


  public function socialLogin(LoginSocialRequest $request)
  {

    $provider = $request->input('provider');
    $token = $request->input('access_token');

    try {
      $providerUser = Socialite::driver($provider)->stateless()->userFromToken($token);
    } catch (Exception $exception) {
      return response()->json([
        'success' => false,
        'error' => 'Unauthorized'
      ], 401);
    }

    $user =  $this->findOrCreate($providerUser, $provider);
    $roles = $user->roles->pluck('slug')->all();

    return response()->json([
      'success' => true,
      'user' =>  new UserResource($user),
      'token' => $user->createToken('API', $roles)->plainTextToken

    ]);
  }

  protected function findOrCreate(AbstractUser $providerUser, string $provider): User
  {
    $linkedSocial = LinkedSocialUser::where('provider_name', $provider)
      ->where('provider_id', $providerUser->getId())
      ->first();

    if ($linkedSocial) {
      return $linkedSocial->user;
    } else {
      $user = null;
      if ($email = $providerUser->getEmail()) {
        $user = User::where('email', $email)->first();
      }

      if (!$user) {
        $user = User::create([
          'name' => $providerUser->getName(),
          'email' => $providerUser->getEmail(),
        ]);
      }
      $user->linkedSocialUsers()->create([
        'provider_id' => $providerUser->getId(),
        'provider_name' => $provider,
      ]);

      return $user;
    }
  }
}
