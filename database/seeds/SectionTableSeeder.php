<?php

use App\Section;
use App\Menu;
use Illuminate\Database\Seeder;

define('SECTIONS_PER_MENU', 3);

class SectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $menus = Menu::all();
        foreach($menus as $menu){
            for($i = 0; $i < SECTIONS_PER_MENU; $i++){
                Section::insert( [
                    'name'=> $faker->randomElement( ['Entradas', 'Comidas', 'Postres', 'Desayunos', 'Del Dia', 'Bebidas'] ),
                    'menu_id' => $menu->id,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]);
            }
        }
    }
}
