<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/register', 'Auth\AuthController@register');
Route::post('/login', 'Auth\AuthController@login');
Route::get('/logout', 'Auth\AuthController@logout');
Route::get('/authenticate', 'Auth\AuthController@auth');

// Home
Route::get('/images', 'HomeController@getImages');

// User
Route::get('/album', 'UserController@getAlbum');
Route::get('/favorites', 'UserController@getFavorites');

Route::post('/avatar/upload', 'UserController@avatarUpload');
Route::post('/avatar/save', 'UserController@avatarSave');
Route::post('/avatar/cancel', 'UserController@avatarCancel');

Route::post('/image/upload', 'ImageController@imageUpload');
Route::post('/image/save', 'ImageController@imageSave');
Route::post('/image/cancel', 'ImageController@imageCancel');
Route::get('/image/{id}/delete', 'ImageController@imageDelete');
Route::get('/image/{id}/like', 'LikeController@likeImage');

// Explore
Route::get('/images/tags/{tags?}', 'ExploreController@getImagesAndTags');