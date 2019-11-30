<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'ProductsName'        => $faker->word,
        'ProductsPrice'       => $faker->randomNumber(2).'000',
        'ProductsDescription' => $faker->text($maxNbChars = 200),
    ];
});
