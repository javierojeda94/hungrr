<?php

use App\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = array(
            [
                'name'=> $faker->name,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'direction' => $faker->address,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        );
        Restaurant::insert($data);
    }
}
