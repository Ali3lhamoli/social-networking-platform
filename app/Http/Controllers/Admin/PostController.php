<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('web.admin.sections.posts.index', compact('posts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = Post::with('user','likes','comments')->find($post->id);
        // dd($post);
        return view('web.admin.sections.posts.show', compact('post'));
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
        return redirect()->route('admin.posts.index');
    }
}
