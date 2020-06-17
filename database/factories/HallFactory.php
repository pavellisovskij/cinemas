<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hall;
use Faker\Generator as Faker;

$factory->defineAs(Hall::class, 'hall', function (Faker $faker) {
    return [
        'name'   => $faker->words(2, true),
        'seats'  => 0,
        'status' => 1,
        'map'    => function () {
            $map = [];
            $rows = rand(1, 30);
            $placesInRow = rand(4, 50);
            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $placesInRow; $j++) {
                    if (rand(0, 1) == 0) {
                        $map[$i][$j] = false;
                    }
                    else {
                        $map[$i][$j] = [
                            'id' => 1,
                            'name' => 'Диван',
                            'amount' => 1.45
                        ];
                    }
                }
            }
            return json_encode($map);
        }
    ];
});
