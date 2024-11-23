<?php

namespace App\Http\Controllers\Site;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['post_id'] = $request->input('post_id');
        $data['user_id'] = auth()->id();
        Like::create($data);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Like::where('post_id', $id)->where('user_id', auth()->id())->delete();
        return redirect()->back();
    }
}
