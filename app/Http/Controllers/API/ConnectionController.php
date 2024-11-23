<?php

namespace App\Http\Controllers\API;

use App\Models\Connection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        $connections = Connection::where('user_id','=', $user_id)->orWhere('friend_id','=', $user_id)->get();
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Connection $connection)
    {
        if($connection){
            return response()->json([
                'status' => 'success',
                'data' => $connection,
                ], 200);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'No data found',
                ], 404);
        }
        

    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
