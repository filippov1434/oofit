<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllProduct(Product $product) : object {
        $result = $product->getAllProduct();
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getProduct(int $id, Product $product) : object {
        if (Product::where('id', $id)->exists()) {
            $result = $product->getOneProduct($id);
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
    public function createProduct(ProductRequest $request) {
        Product::create($request->input("productInfo"));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateProduct(ProductRequest $request, int $id) : object {
        if (Product::where('id', $id)->exists()) {
            $data = $request->input("productInfo");
            Product::where('id', $id)->update($data);
            return response()->json([
                "message" => "Record updated successfully"
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
    public function deleteProduct(int $id) : object {
        if (Product::where('id', $id)->exists()) {
            Product::where('id', $id)->delete();
            //UserProduct::where('product_id', $id)->delete();
            //ProductPage::where('product_id', $id)->delete();
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
