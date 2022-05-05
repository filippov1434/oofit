<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Models\User;
use App\Models\UserSocial;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Actions\Product\OpenProductAction;
use App\Actions\Product\UpdateProductAction;

class UserController extends Controller
{   
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllUsers(User $user) : object {
        $result = $user->getAllUsersFullInfo();
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getUser(int $id, User $user) : object {
        if (User::where('id', $id)->exists()) {
            $result = $user->getOneUserFullInfo($id);
            return response()->json([
                "data" => $result
             ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Create new row
     * 
     * @return object response with JSON (success message)
     */
    public function createUser(UserRequest $request, OpenProductAction $action) : object  {
        //CreateUserInfo
        $userInfo = $request->input("userInfo");
        $id = User::create($userInfo)->id;

        //InsertSocialInfo
        $userSocialInfo = $request->input("userSocialInfo");
        $userSocialInfo += ['user_id' => $id]; 
        UserSocial::create($userSocialInfo);

        //CreateProductsInfo
        $productInfo = $request->input("userProductInfo");// like [1,2,3]
        var_dump($productInfo);
        if (!empty($productInfo['productsId'])) {
            $productArray = $action->handle($id, $productInfo['productsId']);
        };
        
        return response()->json([
            "message" => "Record created"
        ], 201);   
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateUser(UserRequest $request, int $id, UpdateProductAction $action, User $user)  : object {
        if (User::where('id', $id)->exists()) {
            //UpdateUserInfo
            $userInfo = $request->input("userInfo");
            User::where('id', $id)->update($userInfo);

            //UpdateSocialUserInfo
            $userSocialInfo = $request->input("userSocialInfo");
            UserSocial::where('user_id', $id)->update($userSocialInfo);

            //UpdateProductsInfo
            $newProductsArray = $request->input('userProductInfo'); // [1,2] or []
            $action->handle($id, $newProductsArray['productsId']);
            return response()->json([
                "message" => "Record updated"
            ], 200);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }

    /**
     * Delete row by id
     * 
     * @return object response with JSON (success message)
     */
    public function deleteUser(int $id) : object {
        if (User::where('id', $id)->exists()) {
            User::where('id', $id)->delete();
            //UserProduct::where('user_id', $id)->delete();
            return response()->json([
                "message" => "Record deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Record not found"
            ], 404);
        }
    }



}
