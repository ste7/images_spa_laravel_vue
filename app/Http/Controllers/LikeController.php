<?php

namespace App\Http\Controllers;

use App\Image;
use JWTAuth;
use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likeImage(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $image_id = $request->id;

        $imageExists = Image::find($image_id);

        if (! $imageExists) {
            return response()->json([
                'message' => 'Sorry, there was a problem. Please try again later.'
            ], 404);
        }

        $likeExists = $user->didILike($image_id);

        if ($likeExists) {
            $likeExists->delete();

            return response()->json( [
                'status' => 'unliked',
                'like' => $likeExists
            ], 200);
        }

        $like = Like::create([
            'image_id' => $image_id,
            'user_id' => $user->id
        ]);

        return response()->json([
            'status' => 'liked',
            'like' => $like
        ], 200);
    }
}
