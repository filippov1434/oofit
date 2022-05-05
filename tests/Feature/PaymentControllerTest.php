<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\AdminUser;
use App\Models\Page;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\DB;

// php artisan test --filter PaymentControllerTest

class PaymentControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function auth_like_admin() {
        Sanctum::actingAs(
            AdminUser::factory()->create(),
            ['admin']
        );
    }

    public function test_getOnePayment_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/payments/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'paymentDate',
                    'paymentPrice',
                    'userName',
                    'productName'
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.paymentDate' => 'string',
                    'data.paymentPrice' => 'integer',
                    'data.userName' => 'string',
                    'data.productName' => 'string'
                ])
        );
    }
    
    public function test_getAllPayment_function_right_way() {
        $this->auth_like_admin();

        $response = $this->get('api/admin/payments/');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'paymentDate',
                        'paymentPrice',
                        'userName',
                        'productName'
                    ]
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                ->whereAllType([
                    'data.0.paymentDate' => 'string',
                    'data.0.paymentPrice' => 'integer',
                    'data.0.userName' => 'string',
                    'data.0.productName' => 'string'
                ])
        );   
    }

    public function test_createPayment_function_right_way() {
        $this->auth_like_admin();

        $fakeData= [
            "paymentInfo" => [
                "payment_date" => "2010-10-01", 
                "user_id" => 1, 
                "product_id" => 1,
                "price_rub" => 10009]
                
        ];

        $response = $this->postJson('api/admin/payments/', $fakeData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('payments', [
            'payment_date' => $fakeData["paymentInfo"]["payment_date"],
        ]);

    }

    public function test_updatePayment_function_right_way() {
        $this->auth_like_admin();

        $id = 1;
        $fakeData= [
            "paymentInfo" => [
                "payment_date" => "2010-10-01", 
                "user_id" => 1, 
                "product_id" => 1,
                "price_rub" => 10009]
                
        ];

        $response = $this->putJson("api/admin/payments/$id", $fakeData);
        $response->assertStatus(200);

        $this->assertDatabaseHas('payments', [
            'payment_date' => $fakeData["paymentInfo"]["payment_date"],
        ]);
        
    }
    


    public function test_deletePayment_function_right_way() {
        $this->auth_like_admin();
        $fakeid = 1;
        $response = $this->delete("api/admin/payments/$fakeid");
        $response->assertStatus(202);
        
        $this->assertDatabaseMissing('payments', [
            'id' => $fakeid
        ]);
    }


   
}