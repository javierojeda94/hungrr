<?php

use App\Element;
use App\Restaurant;
use Illuminate\Database\Seeder;

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
        $sectionsNumber = RESTAURANTS_NUMBER * 3;
        for($i=0; $i<$sectionsNumber*2 ;$i++){
            if( $i < $sectionsNumber){
                $sectionID = $i + 1;
            }else{
                $sectionID = $i + 1 - $sectionsNumber;
            }

            Element::insert([
                'description' => $faker->sentence(5),
                'name'=> $faker->word,
                'currency' => $faker->currencyCode,
                'image' => $faker->imageUrl(),
                'type' => $faker->randomElement(['bebida','comida', 'postre', 'complemento']),
                'price' => $faker->randomFloat(5),
                'section_id' => $sectionID,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);

        }
    }
}
