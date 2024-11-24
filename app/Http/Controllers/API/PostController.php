<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * @group Post Management
     *
     * Get all posts
     *
     * This endpoint retrieves all posts along with their related users, likes, and comments.
     *
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "content": "This is a sample post",
     *       "user_id": 1,
     *       "image": "storage/posts/sample.jpg",
     *       "created_at": "2024-11-23T10:00:00.000000Z",
     *       "updated_at": "2024-11-23T12:00:00.000000Z",
     *       "user": {
     *         "id": 1,
     *         "name": "Ali"
     *       },
     *       "likes": [],
     *       "comments": []
     *     }
     *   ]
     * }
     */
    public function index()
    {
        $posts = Post::with('user', 'likes', 'comments')->get();
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ], 200);
    }

    /**
     * @group Post Management
     *
     * Create a new post
     *
     * This endpoint creates a new post for a user.
     *
     * @bodyParam content string required The content of the post. Example: "This is a new post."
     * @bodyParam user_id int required The ID of the user creating the post. Example: 1
     * @bodyParam image file The image for the post. Must be a valid image (jpeg, jpg, png, gif, svg). Example: post.jpg
     * @response 201 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "content": "This is a new post.",
     *     "user_id": 1,
     *     "image": "storage/posts/sample.jpg",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "content": ["The content field is required."],
     *     "user_id": ["The user_id field is required."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'user_id' => 'required|int',
            'image' => 'nullaple|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['content', 'user_id', 'image']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->store('/posts', 'public');
            $data['image'] = 'storage/' . $filename;
        }
        $post = Post::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $post,
        ], 201);
    }

    /**
     * @group Post Management
     *
     * Show a specific post
     *
     * This endpoint retrieves the details of a specific post along with its related data.
     *
     * @urlParam id int required The ID of the post. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "content": "This is a sample post",
     *     "user_id": 1,
     *     "image": "storage/posts/sample.jpg",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:00:00.000000Z",
     *     "user": {
     *       "id": 1,
     *       "name": "Ali"
     *     },
     *     "likes": [],
     *     "comments": []
     *   }
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "Post not found"
     * }
     */
    public function show(string $id)
    {
        $post = Post::with('user', 'likes', 'comments')->find($id);
        if ($post) {
            return response()->json([
                'status' => 'success',
                'data' => $post,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ], 404);
        }
    }

    /**
     * @group Post Management
     *
     * Update a specific post
     *
     * This endpoint updates the details of a specific post.
     *
     * @urlParam post int required The ID of the post. Example: 1
     * @bodyParam content string The content of the post. Example: "Updated post content."
     * @bodyParam image file The updated image for the post. Example: updated.jpg
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "content": "Updated post content.",
     *     "image": "storage/posts/updated.jpg",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:30:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "content": ["The content field must be a string."]
     *   }
     * }
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'nullaple|string',
            'image' => 'nullaple|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['content', 'image']);

        if ($request->hasFile('image')) {
            if ($post->image) {
                unlink(public_path($post->image));
            }
            $file = $request->file('image');
            $filename = $file->store('/posts', 'public');
            $data['image'] = 'storage/' . $filename;
        }
        $post->fill(array_filter($data))->save();
        return response()->json([
            'status' => 'success',
            'data' => $post,
        ], 200);
    }

    /**
     * @group Post Management
     *
     * Delete a specific post
     *
     * This endpoint deletes a specific post.
     *
     * @urlParam post int required The ID of the post. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "Post deleted successfully"
     * }
     */
    public function destroy(Post $post)
    {
        if ($post->image) {
            unlink(public_path($post->image));
        }
        $post->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
        ], 200);
    }
}
