<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('web.site.pages.settings');
    }

    public function account_settings(Request $request)
    {
        $user = auth()->id();
        $data = $request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $user,
                'bio' => 'required|string',
            ]
        );
        User::where('id', '=', $user)->update($data);
        return redirect()->back();
    }

    public function profile_picture(Request $request)
    {
        $user = auth()->user();
        $request->validate(
            [
                'image' => 'required|image|mimes:jpg,jpeg,png,gif'
            ]
        );
        if($user->image){
            unlink(public_path($user->image));
        }
        $file = $request->file('image');
        $filename = $file->store('/users','public');
        $data['image'] = 'storage/' . $filename;
        User::where('id', '=', auth()->id())->update($data);
        return redirect()->back();
    }

    public function security_settings(Request $request)
    {
        $user = auth()->id();
        $data = $request->validate(
            [
                'current_password' => 'required|string|min:8|current_password',
                'password' => 'required|string|min:8|confirmed',
            ]
        );
        $new_pass = Hash::make($request->input('password'));
        User::where('id', '=', $user)->update(['password' => $new_pass]);
        return redirect()->back();
    }
}
