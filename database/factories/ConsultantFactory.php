<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\consultant;
use Faker\Generator as Faker;

$factory->define(consultant::class, function (Faker $faker) {
    return [
        'nama'      =>  $faker->name(),
        'website'   =>  $faker->domainName(),
        'telepon'   =>  $faker->phoneNumber,
        'email'     =>  $faker->safeEmail,
        'facebook'  =>  $faker->word,
        'instagram' =>  $faker->word,
        'lokasi'    =>  $faker->address,
    ];
});
