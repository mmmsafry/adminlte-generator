<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuration;
use Faker\Generator as Faker;

$factory->define(Configuration::class, function (Faker $faker) {

    return [
        'config_description' => $faker->text,
        'config_value' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'modified_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
