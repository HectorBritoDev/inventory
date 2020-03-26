<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'code' => $faker->ean8,
        'quantity' => $faker->randonNumber(3),
        'price' => $faker->randonNumber(7),
    ];
});
