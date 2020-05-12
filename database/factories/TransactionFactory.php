<?php

/** @var Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(
    Transaction::class, function (Faker $faker) {
    return [
        'type' => 'debit',
        'amount' => $faker->numberBetween(200, 30000),
    ];
});


$factory->state(Transaction::class, 'credit', function($faker) {
    return [
        'type' => 'credit',
    ];
});
