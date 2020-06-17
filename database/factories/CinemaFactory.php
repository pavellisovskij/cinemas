<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cinema;
use Faker\Generator as Faker;

$factory->defineAs(Cinema::class, 'cinema', function (Faker $faker) {
    return [
        'name'        => $faker->company,
        'description' => $faker->text
    ];
});
