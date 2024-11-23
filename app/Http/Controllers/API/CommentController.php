<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'user_id' => 'required|int',
            'post_id' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['content', 'user_id', 'post_id']);
        $comment = Comment::create($data);
        return response()->json(['status' => 'success', 'message' => 'Comment created successfully 
        ', 'data' => $comment], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        if ($comment) {
            return response()->json([
                'status' => 'success',
                'data' => $comment,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['content']);
        $comment->update($data);
        return response()->json(['status' => 'success', 'message' => 'Comment updated successfully
        ', 'data' => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {

        if ($comment) {
            $comment->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Comment deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Comment not found',
            ], 404);
        }
    }
}
