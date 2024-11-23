<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'search' => 'required|string|max:50',
        ]);
        $search = $data['search'];
        $users = User::where('name', 'like', '%' . $search
        . '%')->orWhere('email', 'like',$search)->get();
        return view('web.site.pages.search', compact('users'));

    }
}
