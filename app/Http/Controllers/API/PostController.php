<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user','likes','comments')->get();
        return response()->json([
            'status' => 'success',
            'data' => $posts,
        ], 200);    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::with('user','likes','comments')->find($id);
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
     * Update the specified resource in storage.
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
            if($post->image){
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
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->image){
            unlink(public_path($post->image));
        }
        $post->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Post deleted successfully',
            ], 200);
        
    }
}
