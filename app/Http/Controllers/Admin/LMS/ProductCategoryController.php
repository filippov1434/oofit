<?php

namespace App\Http\Controllers\Admin\LMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Return info about all rows in JSON
     * 
     * @return object $result is array of JSON for each row
     */
    public function getAllProductCategory(ProductCategory $productCategory) : object {
        $result = $productCategory->getAllProductCategoryInfo();     
        return response()->json([
            "data" => $result
         ], 200);
    }

    /**
     * Return info about 1 row in JSON, by id
     * 
     * @return object $result is array with JSON for 1 row
     */
    public function getProductCategory(int $id, ProductCategory $productCategory) : object {
        if (ProductCategory::where('id', $id)->exists()) {
            $result = $productCategory->getOneProductCategoryInfo($id);
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
    public function createProductCategory(ProductCategoryRequest $request) : object {
        ProductCategory::create($request->input("productCategoriesInfo"));
        return response()->json([
            "message" => "Record created"
        ], 201);
    }

    /**
     * Update row by id
     * 
     * @return object response with JSON (success message)
     */
    public function updateProductCategory(ProductCategoryRequest $request, int $id) : object {
        if (ProductCategory::where('id', $id)->exists()) {
            $data = $request->input("productCategoriesInfo");
            ProductCategory::where('id', $id)->update($data);
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
    public function deleteProductCategory(int $id) : object {
        if (ProductCategory::where('id', $id)->exists()) {
            ProductCategory::where('id', $id)->delete();

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
