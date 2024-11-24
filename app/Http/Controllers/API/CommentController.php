<?php

namespace App\Http\Controllers\API;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * @group Comment Management
     *
     * Create a new comment
     *
     * This endpoint allows a user to create a comment on a post.
     *
     * @bodyParam content string required The content of the comment. Example: "Great post!"
     * @bodyParam user_id int required The ID of the user making the comment. Example: 1
     * @bodyParam post_id int required The ID of the post being commented on. Example: 10
     * @response 201 scenario="success" {
     *   "status": "success",
     *   "message": "Comment created successfully",
     *   "data": {
     *     "id": 1,
     *     "content": "Great post!",
     *     "user_id": 1,
     *     "post_id": 10,
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "content": ["The content field is required."],
     *     "user_id": ["The user_id field is required."],
     *     "post_id": ["The post_id field is required."]
     *   }
     * }
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
     * @group Comment Management
     *
     * Show a specific comment
     *
     * This endpoint retrieves the details of a specific comment.
     *
     * @urlParam comment int required The ID of the comment. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "content": "Great post!",
     *     "user_id": 1,
     *     "post_id": 10,
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "Comment not found"
     * }
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
     * @group Comment Management
     *
     * Update a specific comment
     *
     * This endpoint allows a user to update a specific comment.
     *
     * @urlParam comment int required The ID of the comment. Example: 1
     * @bodyParam content string required The updated content of the comment. Example: "Updated comment content."
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "Comment updated successfully",
     *   "data": {
     *     "id": 1,
     *     "content": "Updated comment content.",
     *     "user_id": 1,
     *     "post_id": 10,
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "content": ["The content field is required."]
     *   }
     * }
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
     * @group Comment Management
     *
     * Delete a specific comment
     *
     * This endpoint allows a user to delete a specific comment.
     *
     * @urlParam comment int required The ID of the comment. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "Comment deleted successfully"
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "Comment not found"
     * }
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
