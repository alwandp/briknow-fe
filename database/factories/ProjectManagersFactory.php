<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\project_managers;
use Faker\Generator as Faker;

$factory->define(project_managers::class, function (Faker $faker) {
    return [
        'nama'  =>  $faker->name(),
        'email' =>  $faker->safeEmail,
    ];
});
