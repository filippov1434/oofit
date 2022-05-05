<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use Laravel\Sanctum\Sanctum;


// php artisan test --filter ApplicationControllerTest

class ApplicationControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOneApplication_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/applications/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'applicationId',
                    'applicationDate',
                    'userName',
                    'productName'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.applicationId' => 'integer',
                    'data.applicationDate' => 'string',
                    'data.userName' => 'string',
                    'data.productName' => 'string'
                ])
        );
    }
    
    public function test_getAllApplication_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/applications/');
        $response
            ->assertStatus(200)
            ->assertJsonFragment(['applicationId' => 1])
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'applicationId',
                        'applicationDate',
                        'userName',
                        'productName'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.applicationId' => 'integer',
                    'data.0.applicationDate' => 'string',
                    'data.0.userName' => 'string',
                    'data.0.productName' => 'string'
                ])
        );   
    }

    public function test_createApplication_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "applicationInfo" => [
                "app_date" => "2010-10-01", 
                "user_id" => 1, 
                "product_id" => 1]
        ];

        $response = $this->postJson('api/admin/applications/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('applications', [
            'app_date' => $fakeData["applicationInfo"]["app_date"],
        ]);

    }

    public function test_updateApplication_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "applicationInfo" => ["app_date" => "2010-10-01", "user_id" => 1, "product_id" => 1]
        ];

        $response = $this->putJson("api/admin/applications/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('applications', [
            'app_date' => $fakeData["applicationInfo"]["app_date"],
        ]);
        
    }
    


    public function test_deleteApplication_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/applications/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('applications', [
            'id' => $fakeid
        ]);
    }


   
}