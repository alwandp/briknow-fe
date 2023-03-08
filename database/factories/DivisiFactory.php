<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\divisi;
use Faker\Generator as Faker;

$factory->define(divisi::class, function (Faker $faker) {
    return [
        'direktorat'        =>  $faker->word(),
        'divisi'            =>  $faker->word()
    ];
});
