<?php

use App\Element;
use App\Restaurant;
use App\Section;
use Illuminate\Database\Seeder;

define('ELEMENTS_PER_SECTION', 2);

class ElementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $sections = Section::all();
        foreach($sections as $section){
            $itemDictionary = $this->getItemDictionary()[$section->name];
            for($i = 0; $i < ELEMENTS_PER_SECTION; $i++){
                $itemName = $faker->randomElement($itemDictionary);
                $itemDictionary = array_diff($itemDictionary, array($itemName));
                Element::insert([
                    'description' => $this->getDescription($section->name),
                    'name'=> $itemName,
                    'currency' => 'MXN',
                    'image' => $faker->imageUrl(),
                    'type' => $this->getType($section->name),
                    'price' => $faker->randomFloat(2, 0, 1000),
                    'section_id' => $section->id,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]);
            }
        }
    }

    public function getItemDictionary( ){
        return array(
            SECTION_NAME_ENTRADAS => array('Pasta', 'Arroz Blanco', 'Puré de Papa', 'Rollo Primavera', 'Arroz Frito', 'Sopa de Pollo',
                'Pan con aderezo', 'Totopos con Guacamole'),
            SECTION_NAME_COMIDAS => array('Costillas Asadas', 'Hamburguesa Grill', 'Arrachera Asada', 'Pollo a la Plancha', 'Pechuga Parmesana',
                'Ensalada César', 'Bisteces a la Mexicana', 'Pollo a la naranja', 'Pozole', 'Mondongo', 'Salbutes', 'Huaraches',
                'Burrito Grande', 'Tacos Dorados', 'Sushi', 'Fajitas de Pollo', 'Poc Chuc', 'Barbacoa', 'Cochinita', 'Frijol con Puerco'),
            SECTION_NAME_POSTRES => array('Helado de Fresa', 'Helado de Vainilla','Helado de Chocolate','Helado de Napolitano','Helado de Chocomenta','
            Helado de Guanabana', 'Helado de Coco','Helado de Chocochips','Helado de Limon','Helado de Oreo','Helado de Yoghurt',
                'Galleta de Chispas de Chocolate', 'Rebanada de Pay de Limon', 'Rebanada de Pastel', 'Rebanada de Volteado de Piña'),
            SECTION_NAME_DESAYUNOS => array('Huevos Motuleños', 'Hot Cakes', 'Waffles', 'Cóctel de Frutas', 'Cereal con Frutas', 'Batido de Herbalife'),
            'Del Dia' => array('Costillas Asadas', 'Hamburguesa Grill', 'Arrachera Asada', 'Pollo a la Plancha', 'Pechuga Parmesana',
                'Ensalada César', 'Bisteces a la Mexicana', 'Pollo a la naranja', 'Pozole', 'Mondongo', 'Salbutes', 'Huaraches',
                'Burrito Grande', 'Tacos Dorados', 'Sushi', 'Fajitas de Pollo', 'Poc Chuc', 'Barbacoa', 'Cochinita', 'Frijol con Puerco'),
            SECTION_NAME_BEBIDAS => array('XX-Lagger', 'Refresco de Cola', 'Refresco de Lata', 'Agua Natural', 'Limonada Rosa!', 'Cerveza',
                'Agua Natural', 'Té')
        );
    }

    public function getType($sectionName){
        if( strcmp($sectionName, SECTION_NAME_ENTRADAS) == 0){
            return 'complemento';
        } else if(strcmp($sectionName, SECTION_NAME_POSTRES) == 0){
            return 'postre';
        }else if(strcmp($sectionName, SECTION_NAME_BEBIDAS) == 0){
            return 'bebida';
        }else{
            return 'comida';
        }
    }

    private function getDescription($sectionName){
        if( strcmp($sectionName, SECTION_NAME_ENTRADAS) == 0){
            return 'Complemento perfecto para acompañar tu comida principal 200gr.';
        } else if(strcmp($sectionName, SECTION_NAME_POSTRES) == 0){
            return 'Delicioso postre cuya dulzura te cautivará.';
        }else if(strcmp($sectionName, SECTION_NAME_BEBIDAS) == 0){
            return 'Bebida refrescante no rellenable.';
        }else if( strcmp($sectionName, SECTION_NAME_DESAYUNOS) == 0){
            return 'Desayuno completo con uuna buena cantidad de proteina.';
        }else if( strcmp($sectionName, SECTION_NAME_DEL_DIA) == 0 ){
            return 'Comida principal del dia';
        }else{
            return 'Comida principal preparada con los mas finos ingredientes naturales.';
        }
    }
}
