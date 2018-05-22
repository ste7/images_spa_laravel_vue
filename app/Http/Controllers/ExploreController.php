<?php

namespace App\Http\Controllers;

use App\Image;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;

class ExploreController extends Controller
{
    public function getImagesAndTags(Request $request)
    {
        $tagsArray = $request->input('tags');

        $tags = DB::table('image_tag')
            ->select(DB::raw('count(*) as count, tags.*'))
            ->join('tags', 'tags.id', '=', 'image_tag.tag_id')
            ->groupBy('tag_id')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        if (! count($tagsArray)) {
            $images = Image::with('likes', 'user', 'user.likes')->get();

            return response()->json([
                'images' => $images,
                'tags' => $tags,
            ], 200);
        }

        $images = Image::with('likes', 'user', 'user.likes')->whereHas('tags', function ($q) use ($tagsArray) {
            $q->whereIn('tags.id', $tagsArray);
        })->get();

        return response()->json([
            'images' => $images,
            'tags' => $tags
        ], 200);
    }
}