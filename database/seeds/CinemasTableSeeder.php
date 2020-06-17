<?php

use Illuminate\Database\Seeder;
use App\Cinema;
use App\Address;
use App\Hall;

class CinemasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cinema::class, 'cinema', 50)->create()->each(function ($cinema) {
            $cinema->address()->save(factory(Address::class, 'address')->make());
            $cinema->hall()->createMany(factory(Hall::class, 'hall', rand(1,3))->make()->toArray());
        });
    }
}
