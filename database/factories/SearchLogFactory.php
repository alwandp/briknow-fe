<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\search_log;
use Faker\Generator as Faker;

$factory->define(search_log::class, function (Faker $faker) {
    return [
        'user_id'       =>  $faker->numberBetween(1,3),
        'project_id'    =>  $faker->numberBetween(1,3),
    ];
});
