<?php

use App\Element;
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
        $sampleImagePath = 'images/elements/sample_element.png';
        $faker = Faker\Factory::create();
        $elementsNumber = 10;
        for($i = 0; $i < $elementsNumber; $i++){
            $data = array(
                [
                    'description' => $faker->sentence(5),
                    'name'=> $faker->word,
                    'currency' => $faker->currencyCode,
                    'image' => $sampleImagePath,
                    'price' => $faker->randomFloat(5),
                    'section_id' => rand(1,3),
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
            );
            Element::insert($data);
        }
    }
}
