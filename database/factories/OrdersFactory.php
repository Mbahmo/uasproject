<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Orders;
use Faker\Generator as Faker;

$factory->define(Orders::class, function (Faker $faker) {
    return [
        'PaymentsId'      => $faker->numberBetween($min = 1, $max = 10),
        'ProductsId'      => $faker->numberBetween($min = 1, $max = 10),
        'OrdersQuantity'  => $faker->numberBetween($min = 10, $max = 100),
    ];
});
