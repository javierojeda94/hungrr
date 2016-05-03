<?php

use App\Phone;
use App\Restaurant;
use Illuminate\Database\Seeder;

class PhoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $restaurants = Restaurant::all();
        foreach( $restaurants as $restaurant ){
            Phone::insert([
                'restaurant_id' => $restaurant->id,
                'phone'=> $faker->phoneNumber,
                'description' => $faker->sentence(5),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
