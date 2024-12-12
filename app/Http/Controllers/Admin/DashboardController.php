<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Major;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $users = User::where('is_admin', '=', 0)->count();
        $posts = Post::count();
        return view('web.admin.pages.dashboard', compact('users', 'posts'));

    }
}
