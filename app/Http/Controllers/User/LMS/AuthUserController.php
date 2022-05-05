<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthUserController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if(auth("web")->attempt($data)) {
            $admin = User::where('email', $request->email)->first();
            return $admin->createToken('user')->plainTextToken;
        }
        return "Пользователь не найден, либо данные введены не правильно";
    }
}