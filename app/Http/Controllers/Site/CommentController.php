<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $commentRequest)
    {
        $data = $commentRequest->validated();
        $data['user_id'] = auth()->id();
        Comment::create($data);
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            'content' => 'required|string|max:500',
        ]);
        $comment->update($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back();
    }
}
