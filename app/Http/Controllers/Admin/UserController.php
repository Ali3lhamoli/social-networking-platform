<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_admin', '=', 0)->orderBy('id', 'desc')->paginate(5);
        return view("web.admin.sections.users.index",compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("web.admin.sections.users.create");
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $filename = $file->store('/users','public');
            $data['image'] = 'storage/' . $filename;
        }

        if($data['is_admin']){
            $data['is_admin'] = 1;
        }else{
            $data['is_admin'] = 0;
        }

        $user = User::create($data);
        
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("web.admin.sections.users.show",compact('user'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view("web.admin.sections.users.edit",compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();
        if(!$request->password){
            unset($data['password']);
        }
        if($request->hasFile('image')){
            if($user->image){
                unlink(public_path($user->image));
            }
            $file = $request->file('image');
            $filename = $file->store('/users','public');
            $data['image'] = 'storage/' . $filename;
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->image != null){
            unlink(public_path($user->image));
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted successfully');
    }
}
