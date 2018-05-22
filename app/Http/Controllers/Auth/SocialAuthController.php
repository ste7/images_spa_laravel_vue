<?php

namespace App\Http\Controllers\Auth;

use App\ServiceUser;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($service, Request $request)
    {
        $userOauth = Socialite::driver($service)->stateless()->user();

        $user = (new User())->exists($userOauth->getEmail());

        if (! $user) {
            $user = User::create([
                'name' => $userOauth->getName(),
                'email' => $userOauth->getEmail(),
                'avatar' => $userOauth->getAvatar()
            ]);

            $userService = $user->service($service)->first();

            if (! $userService) {
                ServiceUser::create([
                    'user_id' => $user->id,
                    'service' => $service
                ]);
            }
        }

        try {
            if (! $token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'Could not log you in with those details'], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token.'], 500);
        }


        return response()->json([
            'access_token' => $token,
            'user' => [
                'data' => $user,
                'token' => $token
            ]], 200);
    }




    public function handleProviderCallback($service)
    {
        return response()->json(null, 200);
    }
}