<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        if ($users) {
            return response()->json([
                'status' => 'success',
                'data' => $users,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found',
            ], 404);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(User $profile)
    {
        if ($profile) {
            return response()->json([
                'status' => 'success',
                'data' => $profile,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $profile)
    {
        if ($profile) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email',
                'bio' => 'required|string',
                'image' => 'nullaple|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
            }

            $data = $request->only(['name', 'email', 'bio', 'image', 'password']);
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }



            if ($request->hasFile('image')) {
                if ($profile->image) {
                    unlink(public_path($profile->image));
                }
                $file = $request->file('image');
                $filename = $file->store('/users', 'public');
                $data['image'] = 'storage/' . $filename;
            }

            $profile->fill(array_filter($data))->save();

            return response()->json([
                'status' => 'success',
                'data' => $profile,
                'message' => 'User updated successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $profile)
    {
        if ($profile) {
            $profile->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }
    }
}
