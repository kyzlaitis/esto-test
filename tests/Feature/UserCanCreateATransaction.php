<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserCanCreateATransaction extends TestCase
{
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

        $storedTransactionResponse = $response->decodeResponseJson()['data']['attributes'];

        $this->assertEquals($user->id, $storedTransactionResponse['user_id']);
        $this->assertEquals('100.2', $storedTransactionResponse['amount']);
        $this->assertEquals('debit', $storedTransactionResponse['type']);

        $response->assertStatus(201)->assertJson(
            [
                'data' => [
                    'type'       => 'transactions',
                    'attributes' => [
                        'transaction_id' => $storedTransactionResponse->id,
                        'amount'         => $storedTransactionResponse['amount'],
                        'type'           => $storedTransactionResponse['type'],
                        'user_id'        => $storedTransactionResponse['user_id'],
                    ],
                ],
            ]
        );
    }
}
