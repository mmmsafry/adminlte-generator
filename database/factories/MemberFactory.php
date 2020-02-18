<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {

    return [
        'firstName' => $faker->word,
        'last_name' => $faker->word,
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
