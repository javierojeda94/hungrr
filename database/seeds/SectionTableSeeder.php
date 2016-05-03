<?php

use App\Section;
use App\Menu;
use Illuminate\Database\Seeder;

define('SECTIONS_PER_MENU', 3);
define('SECTION_NAME_DESAYUNOS', 'Desayunos');
define('SECTION_NAME_DEL_DIA', 'Del Dia');
define('SECTION_NAME_COMIDAS', 'Comidas');
define('SECTION_NAME_POSTRES', 'Postres');
define('SECTION_NAME_BEBIDAS', 'Bebidas');
define('SECTION_NAME_ENTRADAS', 'Entradas');

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
            $availableSections = [
                SECTION_NAME_ENTRADAS,
                SECTION_NAME_COMIDAS,
                SECTION_NAME_POSTRES,
                SECTION_NAME_DESAYUNOS,
                SECTION_NAME_DEL_DIA,
                SECTION_NAME_BEBIDAS
            ];
            for($i = 0; $i < SECTIONS_PER_MENU; $i++){

                $sectionName = $faker->randomElement( $availableSections );
                $availableSections = array_diff($availableSections, array($sectionName));
                
                Section::insert( [
                    'name'=> $sectionName,
                    'menu_id' => $menu->id,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]);
            }
        }
    }
}
