<?php

namespace App\Actions\Product;

use App\Models\User;
use App\Models\UserProduct;

class UpdateProductAction {
    /**
     * Decide and Insert or delete info "userId - ProductId" into UserProduct
     * 
     * 1) define current Products
     * 2) define content of 2 new arrays: $productsToClose and $productsToOpen
     * 3) delete or insert rows in DB. Or, do nothing, if nothing to change
     * 
     * @param int $id user_id
     * @param array $newProductsArray like [] or [1,2,3]
     * @return mixed void or message
     */ 
    public function handle(int $id, array $newProductsArray) {
        $user = new User;
        $currentProducts = $user->getCurrentProducts($id);
        $currentProductsString = $currentProducts->productList; // NULL or 1,2

        if (is_null($currentProductsString)) {
            $currentProductsArray = []; 
        } else {
            $currentProductsArray = explode(',', $currentProductsString);//[1,2]
        }

        $productsToClose = array_diff($currentProductsArray, $newProductsArray);
        $productsToOpen = array_diff($newProductsArray, $currentProductsArray);
        
        if (!empty($productsToClose)) {
            UserProduct::where('user_id', $id)
                ->whereIn('product_id', $productsToClose)
                ->delete();
        } else if (!empty($productsToOpen)) {
            $sqlArray = [];
            foreach ($productsToOpen as $product_id) {
                array_push($sqlArray, array("user_id" => $id, "product_id" => $product_id ));
            }
            UserProduct::insert($sqlArray);
        } else {
            echo "Nothing to change";
        };  
    }
   
}