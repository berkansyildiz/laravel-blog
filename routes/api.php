<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::resource('tags', 'App\Http\Controllers\Api\TagController');
Route::resource('posts', 'App\Http\Controllers\Api\PostController');
Route::resource('comments', 'App\Http\Controllers\Api\CommentController');

Route::get('/posts/{postId}/tags', ['App\Http\Controllers\Api\PostTagController', 'index'])
    ->where('postId', '[0-9]+');
Route::get('/posts/{postId}/tags/store', ['App\Http\Controllers\Api\PostTagController', 'store'])
    ->where('postId', '[0-9]+');
Route::get('/posts/{postId}/tags/delete', ['App\Http\Controllers\Api\PostTagController', 'destroy'])
    ->where('postId', '[0-9]+');
