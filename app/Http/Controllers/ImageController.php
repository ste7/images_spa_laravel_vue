<?php

namespace App\Http\Controllers;

use App\Image;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use JWTAuth;

class ImageController extends Controller
{
    public function imageUpload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,jpg|min:500|max:2000'
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        $temporary = 'images/user-' . $user->id . '/temporary-' . str_random(20) . '.jpg';

        $image = (new ImageManager())->make($request->file('image'))->encode('jpg', 25);

        Storage::put($temporary, $image->__toString(), 'public');

        $path = Storage::url($temporary);

        return response()->json([
            'path' => $path
        ], 200);
    }



    public function imageSave(Request $request)
    {
        $this->validate($request, [
            'tags' => 'required|array|min:2|max:10',
            'tags.*' => 'required|string|max:15'
        ]);

        $user = JWTAuth::parseToken()->authenticate();

        $explode = explode('/', $request->path);

        $temporary = 'images/user-' . $user->id . '/' . $explode[count($explode) - 1];
        $new = str_replace('temporary', str_random(20), $temporary);

        Storage::move($temporary, $new);

        $path = Storage::url($new);

        $image = Image::create([
            'path' => $path,
            'user_id' => $user->id
        ]);

        $tags = $request->tags;

        foreach ($tags as $t) {
            $tag = Tag::firstOrCreate(['name' => strtolower($t)]);

            $image->tags()->attach($tag->id);
        }

        return response()->json([
            'image' => $image
        ], 200);
    }



    public function imageCancel(Request $request)
    {
        $user = (new User())->user();

        $explode = explode('/', $request->path);

        $storagePath = 'images/user-' . $user->id . '/' . $explode[count($explode) - 1];

        Storage::delete($storagePath);

        return response()->json(null, 204);
    }



    public function imageDelete(Request $request)
    {
        $id = $request->id;

        $image = Image::find($id);

        $explode = explode('/', $image->path);

        $storagePath = 'images/user-' . $image->user_id . '/' . $explode[count($explode) - 1];

        Storage::delete($storagePath);

        $image->delete();

        return response()->json(null, 204);
    }
}
