<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();

        return response()->json(['data' => $comments]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $comment = Comment::create([
            'content' => $request->get('content'),
            'user_id' => $request->get('user_id'),
        ]);

        if ($comment) {
            return response()->json(['message' => 'Successfully created!', 'data' => $comment], 201);
        } else {
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }

    public function show(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found!', 'data' => []], 404);
        }

        return response()->json(['data' => $comment]);
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()], 400);
        }

        $comment= Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found!', 'data' => []], 404);
        }

        if ($comment->update(['content' => $request->get('content')])) {
            return response()->json(['message' => 'Successfully updated!', 'data' => $comment], 201);
        }

        return response()->json(['message' => 'Something went wrong!'], 500);
    }

    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found!', 'data' => []], 404);
        }

        if ($comment->delete()) {
            return response()->json(['message' => 'Successfully deleted!'], 200);
        }

        return response()->json(['message' => 'Something went wrong!'], 500);
    }
}
