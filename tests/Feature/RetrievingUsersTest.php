<?php

namespace Tests\Feature;

use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RetrievingUsersTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function anyone_can_rettrieve_10_last_users_with_debt_sum()
    {
        $users = factory(Transaction::class, 200)->create();

        $response = $this->getJson('/api/users/transactions');


        $response->assertStatus(200);
        $response->assertJson(
            [
                'data' => [
                    'collection' => [
                        [
                            'name' => 'testName',
                            'debitSum' => '12.2',
                        ],
                    ],
                ],
            ]
        );
    }
}
