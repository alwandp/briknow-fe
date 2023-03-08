<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\document;
use Faker\Generator as Faker;

$factory->define(document::class, function (Faker $faker) {
    return [
        'project_id'        =>  $faker->numberBetween(1,3),
        'nama'              =>  $faker->name(),
        'jenis_file'        =>  'mp4',
        'url_file'          =>  'https://www.google.co.id/?hl=id',
        'size'              =>  '10mb'
    ];  
});
