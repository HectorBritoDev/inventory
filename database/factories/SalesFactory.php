<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sale;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence(5),
        'total_price' => $faker->randomNumber(7),
    ];
});
