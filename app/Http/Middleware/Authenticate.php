<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
              /*  
            return response()->json([
                "message" => "YO Unauthorised"
            ], 401);
        */

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            //return route('login');
            return response()->json([
                "message" => "YO Unauthorised"
            ], 401);
        };
    }
              /*  
            return response()->json([
                "message" => "YO Unauthorised"
            ], 401);
        */
}