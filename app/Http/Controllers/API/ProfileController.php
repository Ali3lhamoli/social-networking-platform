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
     * @group Profile Management
     *
     * Get all profiles
     *
     * This endpoint retrieves a list of all user profiles.
     *
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Ali",
     *       "email": "ali@example.com",
     *       "bio": "Laravel Developer",
     *       "image": "storage/users/example.jpg",
     *       "created_at": "2024-11-23T10:00:00.000000Z",
     *       "updated_at": "2024-11-23T12:00:00.000000Z"
     *     }
     *   ]
     * }
     * @response 404 scenario="no data found" {
     *   "status": "error",
     *   "message": "No data found"
     * }
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
     * @group Profile Management
     *
     * Show a specific profile
     *
     * This endpoint retrieves details of a specific user profile.
     *
     * @urlParam profile int required The ID of the profile. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "name": "Ali",
     *     "email": "ali@example.com",
     *     "bio": "Laravel Developer",
     *     "image": "storage/users/example.jpg",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:00:00.000000Z"
     *   }
     * }
     * @response 404 scenario="user not found" {
     *   "status": "error",
     *   "message": "User not found"
     * }
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
     * @group Profile Management
     *
     * Update a specific profile
     *
     * This endpoint updates the details of a specific user profile.
     *
     * @urlParam profile int required The ID of the profile. Example: 1
     * @bodyParam name string The name of the user. Example: Ali Updated
     * @bodyParam email string The email of the user. Example: ali@example.com
     * @bodyParam bio string The bio of the user. Example: Updated Bio
     * @bodyParam image file The profile image of the user. Must be a valid image (jpeg, jpg, png, gif, svg). Example: example.jpg
     * @bodyParam password string The password for the user. Example: secret123
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "name": "Ali Updated",
     *     "email": "ali@example.com",
     *     "bio": "Updated Bio",
     *     "image": "storage/users/updated.jpg",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:30:00.000000Z"
     *   },
     *   "message": "User updated successfully"
     * }
     * @response 404 scenario="user not found" {
     *   "status": "error",
     *   "message": "User not found"
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "name": ["The name field is required."],
     *     "email": ["The email must be a valid email address."]
     *   }
     * }
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
     * @group Profile Management
     *
     * Delete a specific profile
     *
     * This endpoint deletes a specific user profile.
     *
     * @urlParam profile int required The ID of the profile. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "User deleted successfully"
     * }
     * @response 404 scenario="user not found" {
     *   "status": "error",
     *   "message": "User not found"
     * }
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
