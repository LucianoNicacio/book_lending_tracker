<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:friends,email',
            'phone' => 'nullable|string|max:50',
        ]);

        $friend = Friend::create($data);

        return response()->json($friend, 201);
    }
}
