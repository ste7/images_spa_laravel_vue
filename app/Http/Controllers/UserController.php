<?php

namespace App\Http\Controllers;

use App\Image;
use App\Like;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use JWTAuth;

class UserController extends Controller
{
    public function avatarUpload(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        $path = 'avatars/user-' . $user->id . '/temporary-' . str_random(20) . '.png';

        $image = (new ImageManager())->make($request->file('avatar'))
            ->fit(200, 200, function ($c) {
                $c->aspectRatio();
            })->encode('png');

        Storage::put($path, $image->__toString(), 'public');

        $url = Storage::url($path);

        return response()->json([
            'path' => $url
        ], 200);
    }



    public function avatarSave(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $explode = explode('/', $request->path);
        $explodeOld = explode('/', $user->avatar);

        $temporary = 'avatars/user-' . $user->id . '/' . $explode[count($explode) - 1];
        $new = str_replace('temporary', str_random(20), $temporary);
        $old = 'avatars/user-' . $user->id . '/' . $explodeOld[count($explodeOld) - 1];

        Storage::move($temporary, $new);
        Storage::delete($temporary);
        Storage::delete($old);

        $path = Storage::url($new);

        User::where('id', $user->id)
            ->update([
                'avatar' => $path
            ]);

        return response()->json([
            'path' => $path
        ], 200);
    }



    public function avatarCancel(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $explode = explode('/', $request->path);
        $temporary = 'avatars/user-' . $user->id . '/' . $explode[count($explode) - 1];

        Storage::delete($temporary);

        return response()->json([
            'path' => $user->avatar
        ], 200);
    }



    public function getAlbum()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $images = Image::with('likes', 'myLike', 'user.likes')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'images' => $images
        ], 200);
    }



    public function getFavorites()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $images = Like::with('images', 'images.user')->where('user_id', $user->id)->get();

        return response()->json([
            'images' => $images
        ], 200);
    }
}
