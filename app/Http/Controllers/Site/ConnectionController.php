<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Connection;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $excepted_users1 = Connection::where('user_id', auth()->id())->pluck('friend_id')->toArray();
        $excepted_users2 = Connection::where('friend_id', auth()->id())->pluck('user_id')->toArray();
        $users = User::whereNotIn('id', array_merge($excepted_users1, $excepted_users2, [auth()->id()]))->orderBy('id', 'desc')->paginate(6);

        return view('web.site.pages.friends.friends', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $requests1 = Connection::where([
        //     ['user_id', auth()->id()],
        //     ['status', 'pending'],
        // ])->pluck('friend_id')->toArray();

        $requests2 = Connection::where([
            ['friend_id', auth()->id()],
            ['status', 'pending'],
        ])->pluck('user_id')->toArray();

        $users = User::whereIn('id', array_merge( $requests2))->orderBy('id', 'desc')->paginate(6);

        return view('web.site.pages.friends.requests', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
        ]);
        Connection::create([
            'user_id' => auth()->id(),
            'friend_id' => $request->friend_id,
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $friends1 = Connection::where([
            ['user_id', auth()->id()],
            ['status', 'accepted'],
        ])->pluck('friend_id')->toArray();

        $friends2 = Connection::where([
            ['friend_id', auth()->id()],
            ['status', 'accepted'],
        ])->pluck('user_id')->toArray();

        $users = User::whereIn('id', array_merge($friends1, $friends2))->orderBy('id', 'desc')->paginate(6);

        return view('web.site.pages.friends.list', compact('users'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($id);
        Connection::where([
            ['friend_id','=', auth()->id()],
            ['user_id','=', $id],
        ])->update(['status' => 'accepted']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Connection::where([
            ['user_id', '=', auth()->id()],
            ['friend_id', '=', $id],
        ])->orWhere([
            ['user_id' , '=', $id],
            ['friend_id' , '=', auth()->id()],
        ])->delete();
        return redirect()->back();
    }
}
