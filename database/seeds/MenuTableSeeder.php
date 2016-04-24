<?php

use App\Menu;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i=0; $i<RESTAURANTS_NUMBER; $i++){
            Menu::insert(
                [
                    'name'=> $faker->word,
                    'restaurant_id' => $i + 1,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
            );
        }
    }
}
