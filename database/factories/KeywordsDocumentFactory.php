<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\keywords_document;
use Faker\Generator as Faker;

$factory->define(keywords_document::class, function (Faker $faker) {
    return [
        'document_id'   =>  $faker->numberBetween(1,3),
        'name'          =>  $faker->name()
    ];
});
