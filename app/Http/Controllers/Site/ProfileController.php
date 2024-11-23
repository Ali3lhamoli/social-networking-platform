<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if($request->input('user_id')){
            $user = User::find($request->input('user_id'));
        }else{
            $user = auth()->user();
        }
        $friends = Connection::where([
            ['user_id', '=', $user->id],
            ['status', '=', 'accepted'],
        ])->orWhere([
            ['friend_id', '=', $user->id],
            ['status', '=', 'accepted'],
        ])->get();
        $posts = Post::with('likes','comments')->where('user_id', $user->id)->orderBy('id', 'desc')->get();
        // dd();
        return view('web.site.pages.profile', compact('user', 'posts', 'friends'));
    }
}
