<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all posts from the database
        $posts = Post::all();

        // Return the fetched data as a JSON response
        return response()->json(['data' => $posts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:posts|max:255',
            'description' => 'required',
        ]);

        // If validation fails, return error message
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        // Prepare data for new post
        $postData = $request->only(['name', 'description']);

        // Create new post
        $post = Post::create($postData);

        // Return success or error message
        if ($post) {
            return response()->json(['message' => 'Post successfully created!', 'data' => $post], 201);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the post with its associated posts using the provided id
        $post = Post::find($id);

        // If the post does not exist, return a 'Post not found!' message
        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        // If the post is found, return the post data
        return response()->json(['data' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:posts|max:255',
        ]);

        // If validation fails, return error message
        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        // Find the post with its associated posts using the provided id
        $post = Post::find($id);

        // If the post does not exist, return a 'Post not found!' message
        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        // Attempt to update the post's name
        if ($post->update(['name' => $request->get('name')])) {
            // If successful, return a 'Post successfully updated!' message along with the updated post data
            return response()->json([
                'message' => 'Post successfully updated!',
                'data' => $post
            ], 201);
        }

        // If something goes wrong during the update process, return an error message
        return response()->json(['message' => 'Something went wrong!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the post with its associated posts using the provided id
        $post = Post::find($id);

        // If the post does not exist, return a 'Post not found!' message
        if (!$post) {
            return response()->json(['message' => 'Post not found!', 'data' => []], 404);
        }

        // Attempt to delete the post
        if ($post->delete()) {
            // If successful, return a 'Successfully deleted!' message
            return response()->json(['message' => 'Successfully deleted!'], 200);
        }

        // If something goes wrong during the deletion process, return an error message
        return response()->json(['message' => 'Something went wrong!'], 500);
    }

}



