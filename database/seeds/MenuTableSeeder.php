<?php

use App\Menu;
use App\Restaurant;
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
        $restaurants = Restaurant::all();
        foreach( $restaurants as $restaurant ){
            Menu::insert(
                [
                    'name'=> 'Menú de ' . $restaurant->name,
                    'restaurant_id' => $restaurant->id,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
            );
        }
    }
}
