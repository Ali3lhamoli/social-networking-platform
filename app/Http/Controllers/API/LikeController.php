<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Remove the specified resource from storage.
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
