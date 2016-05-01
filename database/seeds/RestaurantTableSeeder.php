<?php

use App\Restaurant;
use Illuminate\Database\Seeder;

define('RESTAURANTS_NUMBER', 1000);

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * latitude and longitude inside Merida
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->delete();
        $faker = Faker\Factory::create();
        for($i=0; $i < RESTAURANTS_NUMBER; $i++){
            Restaurant::insert(
                [
                    'name'=> $faker->name,
                    'latitude' => $faker->randomFloat(8,20.946246, 21.035115),
                    'longitude' => $faker->randomFloat(8,-89.664869, -89.573056),
                    'price' => $faker->randomFloat(2,100,1000),
                    'direction' => $faker->address,
                    'type' => $faker->randomElement(['infantil','marisco', 'bar', 'vegetariano', 'buffet']),
                    'image' => $faker->imageUrl(),
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
            );
        }
    }
}
