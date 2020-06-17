<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->defineAs(Address::class, 'address', function (Faker $faker) {
    return [
        'longitude' => $faker->latitude,
        'latitude'  => $faker->latitude,
        'street'    => $faker->streetAddress,
        'phone'     => $faker->phoneNumber,
        'city'      => $faker->city,
        'country'   => $faker->country
    ];
});
