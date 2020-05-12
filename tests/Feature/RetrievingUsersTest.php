<?php

namespace Tests\Feature;

use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RetrievingUsersTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function anyone_can_rettrieve_10_last_users_with_debt_sum()
    {

        factory(User::class, 20)->state('user')->create()->each(function ($user) {
            $user->transactions()->createMany(factory(Transaction::class, 20)->make()->toArray());
        });

        $response = $this->getJson('/api/users/transactions');
        $decodedTopTen = $response->decodeResponseJson();

        $response->assertJsonCount(10);
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                '*' => [
                    'name',
                    'debitSum',
                ]
            ]
        );
    }
}
