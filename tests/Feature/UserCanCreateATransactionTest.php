<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCanCreateATransactionTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function a_user_can_create_transaction()
    {
        $this->actingAs($user = factory(User::class)->create(['permission' => false]), 'api');

        $response = $this->postJson(
            '/api/transactions',
            [
                'data' => [
                    'type'       => 'transactions',
                    'attributes' => [
                        'amount'  => '100.2',
                        'type'    => 'debit',
                    ],
                ],
            ]
        );
        $response->assertStatus(201);

        $storedTransactionResponse = $response->decodeResponseJson()['data']['attributes'];

        $this->assertEquals($user->id, $storedTransactionResponse['user_id']);
        $this->assertEquals('100.2', $storedTransactionResponse['amount']);
        $this->assertEquals('debit', $storedTransactionResponse['type']);

        $response->assertJson(
            [
                'data' => [
                    'type'       => 'transactions',
                    'attributes' => [
                        'transaction_id' => $storedTransactionResponse['transaction_id'],
                        'amount'         => $storedTransactionResponse['amount'],
                        'type'           => $storedTransactionResponse['type'],
                        'user_id'        => $storedTransactionResponse['user_id'],
                    ],
                ],
            ]
        );
    }
}
