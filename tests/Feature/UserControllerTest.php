<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use App\Models\Page;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;

// php artisan test --filter UserControllerTest

class UserControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOneUser_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/users/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'userId',
                    'userName',
                    'userEmail',
                    'statusName',
                    'instagram',
                    'telegram',
                    'vk',
                    'whatsapp',
                    'productList'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.userId' => 'integer',
                    'data.userName' => 'string',
                    'data.userEmail' => 'string',
                    'data.statusName' => 'string',
                    'data.instagram' => 'string|null',
                    'data.telegram' => 'string|null',
                    'data.vk' => 'string|null',
                    'data.whatsapp' => 'string|null',
                    'data.productList'=> 'string|null'
                ])
        );
    }
    
    public function test_getAllUser_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/users/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'userId',
                        'userName',
                        'userEmail',
                        'statusName',
                        'instagram',
                        'telegram',
                        'vk',
                        'whatsapp',
                        'productList'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.userId' => 'integer',
                    'data.0.userName' => 'string',
                    'data.0.userEmail' => 'string',
                    'data.0.statusName' => 'string',
                    'data.0.instagram' => 'string|null',
                    'data.0.telegram' => 'string|null',
                    'data.0.vk' => 'string|null',
                    'data.0.whatsapp' => 'string|null',
                    'data.0.productList'=> 'string|null'
                ])
        );   
    }

    public function test_createUser_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "userInfo" => [
                "name" => "fake name for test", 
                "email" => "fakeemail@site.com", 
                "password" => "112345",
                "status_id" => 1
            ],
            "userSocialInfo" => [
                'instagram' => "fake instagram",
                'telegram'=> "fake telegram",
                'vk' => "fake vk",
                'whatsapp' => "fake whatsapp"
            ],
            "userProductInfo" => [
                'productsId' => [1,2,46]
            ]
        ];

        $response = $this->postJson('api/admin/users/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $fakeData["userInfo"]["name"],
        ]);

        $this->assertDatabaseHas('users_socials', [
            'instagram' => $fakeData["userSocialInfo"]["instagram"],
        ]);

        $this->assertDatabaseHas('users_products', [
            'product_id' => 2,
        ]);

    }

    public function test_updateUser_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "userInfo" => [
                "name" => "fake name for test", 
                "email" => "fakeemail@site.com", 
                "password" => "112345",
                "status_id" => 1
            ],
            "userSocialInfo" => [
                'instagram' => "fake instagram",
                'telegram'=> "fake telegram",
                'vk' => "fake vk",
                'whatsapp' => "fake whatsapp"
            ],
            "userProductInfo" => [
                'productsId' => [1,2,46]
            ]
        ];

        $response = $this->putJson("api/admin/users/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'name' => $fakeData["userInfo"]["name"],
        ]);

        $this->assertDatabaseHas('users_socials', [
            'instagram' => $fakeData["userSocialInfo"]["instagram"],
        ]);

        $this->assertDatabaseHas('users_products', [
            'product_id' => 2,
        ]);
    }
    


    public function test_deleteUser_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/users/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('users', [
            'id' => $fakeid
        ]);
    }


   
}