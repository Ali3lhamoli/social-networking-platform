<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with('user', 'likes', 'comments')->inRandomOrder()->paginate(5);
        return view('web.site.pages.home', compact('posts'));
    }

    public function fetchPosts(Request $request)
    {
        $posts = Post::with('user', 'likes', 'comments')->inRandomOrder()->paginate(5);
        return view('web.site.partials.posts', compact('posts'))->render();
    }
}
