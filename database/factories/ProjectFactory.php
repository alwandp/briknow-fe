<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\project;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(project::class, function (Faker $faker) {
    $nama       =   $faker->word();
    $date       =   Carbon::now();
    return [
        'consultant_id'             =>  $faker->randomElement($array = array ('1','2','3')),
        'divisi_id'                 =>  $faker->randomElement($array = array ('1','2','3')),
        'project_managers_id'       =>  $faker->randomElement($array = array ('1','2','3')),
        'nama'                      =>  $nama,
        'slug'                      =>  \Str::slug($nama),
        'metodologi'                =>  $faker->sentence(3),
        'tanggal_mulai'             =>  $date,
        'tanggal_selesai'           =>  $date->addMonths(1),
        'status_finish'             =>  $faker->randomElement($array = array ('1','0')),
    ];
});
