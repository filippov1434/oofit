<?php

namespace App\Actions\Product;

use App\Models\UserProduct;

class OpenProductAction {
    /**
     * Insert info "user_id - product_id" into UserProduct
     * 
     * @param int $id user_id
     * @param array $productInfo - array of products id, like [1,2,3]
     * @return void
     */  
    public function handle(int $id, array $productInfo) : void {
        $productArray = [];
        foreach ($productInfo as $product_id) {
            array_push($productArray, array("user_id" => $id, "product_id" => $product_id ));
        }
        UserProduct::insert($productArray);
    }
}