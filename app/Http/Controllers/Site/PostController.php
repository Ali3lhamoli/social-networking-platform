<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $postRequest)
    {
        $data = $postRequest->validated();
        if($postRequest->hasFile('image')){
            $file = $postRequest->file('image');
            $filename = $file->store('/posts','public');
            $data['image'] = 'storage/' . $filename;
        }
        $data['user_id'] = auth()->id();
        // dd($data);
        Post::create($data);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $id)
    {
        $posts = Post::with('user','likes','comments')->find($id);
        // dd($posts);
        return view('web.site.pages.post.show', compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post_id)
    {
        $post = $post_id;
        return view('web.site.pages.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post_id)
    {
        // dd($request);
        $data = $request->validated();
        if($request->hasFile('image')){
            if($post_id->image){
                unlink(public_path($post_id->image));
            }
            $file = $request->file('image');
            $filename = $file->store('/posts','public');
            $data['image'] = 'storage/' . $filename;
        }
        $post_id->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post_id)
    {

        if($post_id->image){
            unlink(public_path($post_id->image));
        }
        $post_id->delete();
        return redirect()->back();
    }
}
