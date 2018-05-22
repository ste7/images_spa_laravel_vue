<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;

class HomeController extends Controller
{
    public function getImages()
    {
        $images = Image::with('likes', 'user.likes')->orderByDesc('created_at')->get();

        return response()->json([
            'images' => $images
        ], 200);
    }
}
