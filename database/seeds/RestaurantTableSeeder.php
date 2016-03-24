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
        $sampleImagePath = 'images/restaurants/sample_restaurant.png';
        $data = array(
            [
                'name'=> $faker->name,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'direction' => $faker->address,
                'type' => $faker->randomElement(['infantil', 'bar', 'vegetariano', 'buffet']),
                'image' => $sampleImagePath,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'name'=> $faker->name,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
                'direction' => $faker->address,
                'type' => $faker->randomElement(['infantil', 'bar', 'vegetariano', 'buffet']),
                'image' => $sampleImagePath,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        );
        Restaurant::insert($data);
    }
}
