<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Sanctum\Sanctum;

class AdminAuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_auth_right_way() : void {
        $response = $this->post ('api/admin/login_admin_process', [
            "email" => "filippov1434@yandex.ru",
            "password" => "1434"
        ]);
        $response->assertStatus(200)
        ->assertJson(fn(AssertableJson $json) =>
            $json->has('token')
        );
    }

    public function test_admin_auth_uncorrect_credentials() : void {
        $response = $this->post ('api/admin/login_admin_process', [
            "email" => "filippov1434@yandex.ru",
            "password" => "100"
        ]);
        $response
        ->assertStatus(401)
        ->assertJson( fn(AssertableJson $json) => 
            $json->where('message', 'Uncorrect email or password')
        );
    }

    public function test_admin_auth_missng_required_field() : void {
        $response = $this->post ('api/admin/login_admin_process', [
            "email" => "filippov1434@yandex.ru"
        ]);
        $response->assertStatus(302);
    }

}
