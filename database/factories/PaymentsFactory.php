<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payments;
use Faker\Generator as Faker;

$factory->define(Payments::class, function (Faker $faker) {
    return [
        'PaymentsName'        => $faker->word,
        'PaymentsDescription' => $faker->text($maxNbChars = 200),
    ];
});
