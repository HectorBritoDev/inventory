<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PurchaseItem;
use Faker\Generator as Faker;

$factory->define(PurchaseItem::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomNumber(3),
    ];
});
