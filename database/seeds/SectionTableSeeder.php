<?php

use App\Section;
use Illuminate\Database\Seeder;

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
        for($i=0; $i<RESTAURANTS_NUMBER*3; $i++){

            if($i < RESTAURANTS_NUMBER){
                $menuID = $i + 1;
            }else if($i < RESTAURANTS_NUMBER*2){
                $menuID = $i + 1 - RESTAURANTS_NUMBER;
            }else{
                $menuID = $i + 1 - RESTAURANTS_NUMBER*2;
            }

            Section::insert( [
                'name'=> $faker->word,
                'menu_id' => $menuID,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ]);
        }
    }
}
