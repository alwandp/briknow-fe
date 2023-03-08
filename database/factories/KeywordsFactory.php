<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\keywords;
use Faker\Generator as Faker;

$factory->define(keywords::class, function (Faker $faker) {
    return [
        'project_id'    =>  $faker->numberBetween(1,3),
        'nama'          =>  $faker->name(),
    ];
});
