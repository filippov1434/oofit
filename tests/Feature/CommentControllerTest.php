<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use Laravel\Sanctum\Sanctum;

// php artisan test --filter CommentControllerTest

class CommentControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOnecomment_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/comments/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'comment',
                    'commentDate',
                    'userEmail'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.comment' => 'string',
                    'data.commentDate' => 'string',
                    'data.userEmail' => 'string'
                ])
        );
    }
    
    public function test_getAllcomment_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/comments/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'comment',
                        'commentDate',
                        'userEmail'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.comment' => 'string',
                    'data.0.commentDate' => 'string',
                    'data.0.userEmail' => 'string'
                ])
        );   
    }

    public function test_createcomment_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "commentInfo" => [
                "user_id" => 1, 
                "comment" => "Comment text", 
                "comment_date" => "2010-10-01"]
        ];

        $response = $this->postJson('api/admin/comments/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'comment_date' => $fakeData["commentInfo"]["comment_date"],
        ]);

    }

    public function test_updatecomment_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "commentInfo" => ["comment_date" => "2010-10-01", "user_id" => 1, "comment" => "TExt comment"]
        ];

        $response = $this->putJson("api/admin/comments/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', [
            'comment_date' => $fakeData["commentInfo"]["comment_date"],
        ]);
        
    }
    


    public function test_deletecomment_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/comments/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('comments', [
            'id' => $fakeid
        ]);
    }


   
}