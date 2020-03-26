<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->ean8,
        'quantity' => $faker->randomNumber(3),
        'unit_price' => $faker->randomNumber(7),
        'mayor_price' => $faker->randomNumber(6),
        'purchase_price' => $faker->randomNumber(5),
    ];
});
