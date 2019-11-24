<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Products;
use Faker\Generator as Faker;

$factory->define(Products::class, function (Faker $faker) {
    return [
        'ProductName'        => $faker->word,
        'ProductStock'       => $faker->numberBetween($min = 10, $max = 50),
        'ProductDescription' => $faker->text($maxNbChars = 200),
    ];
});
