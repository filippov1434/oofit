<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use App\Models\User;
use App\Models\AdminUser;
use Laravel\Sanctum\Sanctum;

// php artisan test --filter ProductControllerTest
class ProductControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOneProduct_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/products/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'productName',
                    'statusName',
                    'categoryName',
                    'languageName'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.productName' => 'string',
                    'data.statusName' => 'string',
                    'data.categoryName' => 'string',
                    'data.languageName' => 'string'
                ])
        );
    }
    
    public function test_getAllProduct_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/products/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'productName',
                        'statusName',
                        'categoryName',
                        'languageName'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.productName' => 'string',
                    'data.0.statusName' => 'string',
                    'data.0.categoryName' => 'string',
                    'data.0.languageName' => 'string'
                ])
        );   
    }

    public function test_createProduct_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "productInfo" => [
                "name" => "fake name for test", 
                "language_id" => 1, 
                "category_id" => 1,
                "status_id" => 1
            ]
        ];

        $response = $this->postJson('api/admin/products/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => $fakeData["productInfo"]["name"],
        ]);
    }

    public function test_updateProduct_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "productInfo" => [
                "name" => "fake name for test", 
                "language_id" => 1, 
                "category_id" => 1,
                "status_id" => 1
            ]
        ];

        $response = $this->putJson("api/admin/products/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => $fakeData["productInfo"]["name"],
        ]);
    }
    


    public function test_deleteProduct_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/products/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('products', [
            'id' => $fakeid
        ]);
    }
    
    
   
}