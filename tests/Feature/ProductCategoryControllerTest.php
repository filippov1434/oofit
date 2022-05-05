<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use App\Models\Page;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;

// php artisan test --filter ProductCategoryControllerTest

class ProductCategoryControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOneProductCategory_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/productCategories/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'categoryName',
                    'statusName'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.categoryName' => 'string',
                    'data.statusName' => 'string'
                ])
        );
    }
    
    public function test_getAllProductCategories_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/productCategories/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'categoryName',
                        'statusName'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.categoryName' => 'string',
                    'data.0.statusName' => 'string'
                ])
        );   
    }

    public function test_createProductCategories_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "productCategoriesInfo" => [
                "name" => "ProductCategories name fake", 
                "status_id" => 1]
        ];

        $response = $this->postJson('api/admin/productCategories/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products_category', [
            'name' => $fakeData["productCategoriesInfo"]["name"],
        ]);

    }

    public function test_updateProductCategories_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "productCategoriesInfo" => [
                "name" => "ProductCategories name fake", 
                "status_id" => 1]
        ];

        $response = $this->putJson("api/admin/productCategories/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products_category', [
            'name' => $fakeData["productCategoriesInfo"]["name"],
        ]);
        
    }
    


    public function test_deleteProductCategories_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/productCategories/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('products_category', [
            'id' => $fakeid
        ]);
    }


   
}