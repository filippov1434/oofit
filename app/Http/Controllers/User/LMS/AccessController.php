<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class AccessController extends Controller
{
    public function getProducts($id, User $user) {
        $result = $user->getOneUserFullInfo($id);
        return $result;
    }
}