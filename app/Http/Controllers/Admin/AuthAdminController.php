<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;

class AuthAdminController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if(auth("admin")->attempt($data)) {
            $admin = AdminUser::where('email', $request->email)->first();
            $token = $admin->createToken('admin', ['admin'])->plainTextToken;
            return response()->json([
                "token" => $token
            ], 200);
        }
        return response()->json([
            "message" => "Uncorrect email or password"
        ], 401);
    }
}