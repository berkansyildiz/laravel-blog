<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();

        return response()->json(['data' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $tag = Tag::create([
           'name' => $request->get('name'),
        ]);

        return response()->json([
            'message' => 'Successfully created!',
            'data' => $tag,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found!', 'data' => []], 404);
        }

        return response()->json(['data' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found!', 'data' => []], 404);
        }

        if ($tag->update(['name' => $request->get('name')])) {
            return response()->json([
                'message' => 'Successfully updated!',
                'data' => $tag
            ], 201);
        }

        return response()->json(['message' => 'Something went wrong!'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            return response()->json(['message' => 'Tag not found!', 'data' => []], 404);
        }

        if ($tag->delete()) {
            return response()->json(['message' => 'Successfully deleted!'], 200);
        }

        return response()->json(['message' => 'Something went wrong!'], 500);
    }

}
