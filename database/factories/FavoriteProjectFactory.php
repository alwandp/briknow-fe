<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\favorite_project;
use Faker\Generator as Faker;

$factory->define(favorite_project::class, function (Faker $faker) {
    return [
        'user_id'           =>  $faker->numberBetween(1,10),
        'project_id'        =>  $faker->numberBetween(1,3),
    ];
});
