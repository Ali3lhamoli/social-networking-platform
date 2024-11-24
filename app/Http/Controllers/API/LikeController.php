<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{

    /**
     * @group Like Management
     *
     * Add a like
     *
     * This endpoint adds a like to a specific post by a specific user.
     *
     * @bodyParam user_id int required The ID of the user who likes the post. Example: 1
     * @bodyParam post_id int required The ID of the post to be liked. Example: 10
     * @response 201 scenario="success" {
     *   "status": "success",
     *   "message": "like created successfully",
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "post_id": 10,
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "user_id": ["The user_id field is required."],
     *     "post_id": ["The post_id field is required."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'post_id' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['user_id', 'post_id']);
        $like = Like::create($data);
        return response()->json(['status' => 'success', 'message' => 'like created successfully 
        ', 'data' => $like], 201);
    }

    /**
     * @group Like Management
     *
     * Show a like
     *
     * This endpoint retrieves details of a specific like.
     *
     * @urlParam like int required The ID of the like. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "post_id": 10,
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "like not found"
     * }
     */
    public function show(Like $like)
    {
        if ($like) {
            return response()->json([
                'status' => 'success',
                'data' => $like,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'like not found',
            ], 404);
        }
    }



    /**
     * @group Like Management
     *
     * Delete a like
     *
     * This endpoint deletes a specific like.
     *
     * @urlParam like int required The ID of the like. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "like deleted successfully"
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "like not found"
     * }
     */
    public function destroy(Like $like)
    {
        if ($like) {
            $like->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'like deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'like not found',
            ], 404);
        }
    }
}
