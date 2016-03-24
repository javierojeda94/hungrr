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
        $data = array(
            [
                'name'=> $faker->word,
                'restaurant_id' => 1,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]
        );
        Menu::insert($data);
    }
}
