<?php

use App\Owner;
use App\Restaurant;
use Illuminate\Database\Seeder;

class OwnerTableSeeder extends Seeder
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
            'name'=> $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'image' => $faker->imageUrl(),
            'password' => bcrypt('password'),
            'remember_token' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        );
        $owner = Owner::create($data);
        $restaurants = Restaurant::all();
        foreach( $restaurants as $restaurant ){
            $owner->restaurants()->attach($restaurant->id);
        }
    }
}
