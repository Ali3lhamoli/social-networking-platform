<?php

namespace App\Http\Controllers\API;

use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConnectionController extends Controller
{
    /**
     * @group Connection Management
     *
     * Get all connections for a user
     *
     * This endpoint retrieves all connections (friend requests) for a specific user.
     *
     * @queryParam user_id int required The ID of the user. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": [
     *     {
     *       "id": 1,
     *       "user_id": 1,
     *       "friend_id": 2,
     *       "status": "pending",
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
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $connections = Connection::where('user_id', '=', $user_id)->orWhere('friend_id', '=', $user_id)->get();
        if ($connections) {
            return response()->json([
                'status' => 'success',
                'data' => $connections,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found',
            ], 404);
        }
    }

    /**
     * @group Connection Management
     *
     * Create a new connection
     *
     * This endpoint creates a new connection (friend request) between two users.
     *
     * @bodyParam user_id int required The ID of the user sending the friend request. Example: 1
     * @bodyParam friend_id int required The ID of the user receiving the friend request. Example: 2
     * @response 201 scenario="success" {
     *   "status": "success",
     *   "message": "Connection created successfully",
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "friend_id": 2,
     *     "status": "pending",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "user_id": ["The user_id field is required."],
     *     "friend_id": ["The friend_id field is required."]
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'friend_id' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['user_id', 'friend_id']);
        $data['status'] = 'pending';
        $connection = Connection::create($data);
        return response()->json(['status' => 'success', 'message' => 'Connection created successfully 
        ', 'data' => $connection], 201);
    }

    /**
     * @group Connection Management
     *
     * Show a specific connection
     *
     * This endpoint retrieves the details of a specific connection.
     *
     * @urlParam connection int required The ID of the connection. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "friend_id": 2,
     *     "status": "pending",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T10:00:00.000000Z"
     *   }
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "Connection not found"
     * }
     */
    public function show(Connection $connection)
    {
        if ($connection) {
            return response()->json([
                'status' => 'success',
                'data' => $connection,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No data found',
            ], 404);
        }
    }

    /**
     * @group Connection Management
     *
     * Update the status of a connection
     *
     * This endpoint updates the status of a specific connection (e.g., accepting the friend request).
     *
     * @urlParam connection int required The ID of the connection. Example: 1
     * @bodyParam user_id int required The ID of the user. Example: 1
     * @bodyParam friend_id int required The ID of the friend. Example: 2
     * @bodyParam status string required The status of the connection. Example: accepted
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "Connection updated successfully",
     *   "data": {
     *     "id": 1,
     *     "user_id": 1,
     *     "friend_id": 2,
     *     "status": "accepted",
     *     "created_at": "2024-11-23T10:00:00.000000Z",
     *     "updated_at": "2024-11-23T12:00:00.000000Z"
     *   }
     * }
     * @response 422 scenario="validation failed" {
     *   "status": "error",
     *   "message": {
     *     "status": ["The status field is required."]
     *   }
     * }
     */
    public function update(Request $request, Connection $connection)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'friend_id' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors(),], 422);
        }
        $data = $request->only(['user_id', 'friend_id']);
        $data['status'] = 'accepted';
        $connection->update($data);
        return response()->json(['status' => 'success', 'message' => 'Connection updated successfully 
        ', 'data' => $connection], 201);
    }

    /**
     * @group Connection Management
     *
     * Delete a specific connection
     *
     * This endpoint deletes a specific connection (friendship).
     *
     * @urlParam connection int required The ID of the connection. Example: 1
     * @response 200 scenario="success" {
     *   "status": "success",
     *   "message": "Connection deleted successfully"
     * }
     * @response 404 scenario="not found" {
     *   "status": "error",
     *   "message": "Connection not found"
     * }
     */
    public function destroy(Connection $connection)
    {
        if ($connection) {
            $connection->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Connection deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection not found',
            ], 404);
        }
    }
}
