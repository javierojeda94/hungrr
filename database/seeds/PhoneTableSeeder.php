<?php

use App\Phone;
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
        for($i=0;  $i<RESTAURANTS_NUMBER*2; $i++){

            if( $i < RESTAURANTS_NUMBER){
                $restaurantID = $i + 1;
            }else{
                $restaurantID = $i + 1 - RESTAURANTS_NUMBER;
            }

            Phone::insert([
                'restaurant_id' => $restaurantID,
                'phone'=> $faker->phoneNumber,
                'description' => $faker->sentence(5),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
