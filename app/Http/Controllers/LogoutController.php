<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return "Succes Logout";
    }
}