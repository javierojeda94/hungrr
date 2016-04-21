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
        $data = array(
            [
                'restaurant_id' => 1,
                'phone'=> $faker->phoneNumber,
                'description' => $faker->sentence(5),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        );
        Phone::insert($data);
    }
}
