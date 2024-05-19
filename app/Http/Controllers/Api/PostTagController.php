<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostTagController extends Controller
{

    public function index(string $postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        return response()->json(['data' => $post->tags]);
    }

    public function store(string $postId, Request $request)
    {
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'tagId' => 'required|numeric|exists:tags,id',
        ]);

        // If validation fails, return error message
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $post->tags()->attach([$request->get('tagId')]);

        return response()->json(['message' => 'Tag successfully attached!'], 200);
    }

    public function destroy(string $postId, Request $request)
    {
        // Validate the incoming request data
        $post = Post::find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'tagId' => 'required|numeric|exists:tags,id',
        ]);

        // If validation fails, return error message
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $post->tags()->detach($request->get('tagId'));

        return response()->json(['message' => 'Tag successfully detached!'], 200);
    }

}
