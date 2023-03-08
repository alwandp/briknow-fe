<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\favorite_consultant;
use Faker\Generator as Faker;

$factory->define(favorite_consultant::class, function (Faker $faker) {
    return [
        'user_id'       =>  $faker->numberBetween(1,3),
        'consultant_id' =>  $faker->numberBetween(1,3),
    ];
});
