<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'unique:users'
        ]);

        $avatar = Storage::url('avatars/default/avatar.png');

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'avatar' => $avatar,
            'password' => bcrypt($request->input('password'))
        ]);

        try {
            if (! $token = JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'Could not register you with those details'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token.'], 500);
        }

        return response()->json([
            'user' => [
                'data' => $user,
                'token' => $token
            ]], 200);
    }



    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'), bcrypt($request->input('password')))->first();
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Could not log you in with those details'], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token.'], 500);
        }

        return response()->json([
            'user' => [
                'data' => $user,
                'token' => $token
            ]], 200);
    }



    public function logout()
    {
        $token = JWTAuth::getToken();

        try {
            JWTAuth::invalidate($token);
            return response()->json([
                'success' => true,
                'message'=> 'You have successfully logged out.'
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to logout, please try again.'
            ], 500);
        }
    }



    public function auth()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            // $user->refresh(); // ????
            $token = JWTAuth::fromUser($user);

            return response()->json([
                'user' => [
                    'data' => $user,
                    'token' => $token
                ]], 200);
        } catch(JWTException $e){
            return response()->json(null, 403);
        }
    }
}
