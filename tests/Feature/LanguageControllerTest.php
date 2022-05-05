<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use App\Models\Page;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;

// php artisan test --filter LanguageControllerTest

class LanguageControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOneLanguage_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/languages/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'languageName',
                    'statusName'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.languageName' => 'string',
                    'data.statusName' => 'string'
                ])
        );
    }
    
    public function test_getAllLanguage_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/languages/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'languageName',
                        'statusName'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.languageName' => 'string',
                    'data.0.statusName' => 'string'
                ])
        );   
    }

    public function test_createLanguage_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "languageInfo" => [
                "name" => "Language name fake", 
                "status_id" => 1]
        ];

        $response = $this->postJson('api/admin/languages/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('languages', [
            'name' => $fakeData["languageInfo"]["name"],
        ]);

    }

    public function test_updateLanguage_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "languageInfo" => ["name" => "Language name", "status_id" => 1]
        ];

        $response = $this->putJson("api/admin/languages/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('languages', [
            'name' => $fakeData["languageInfo"]["name"],
        ]);
        
    }
    


    public function test_deleteLanguage_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/languages/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('languages', [
            'id' => $fakeid
        ]);
    }


   
}