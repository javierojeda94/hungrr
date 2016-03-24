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
        $sectionsNumber = 3;
        for($i = 0; $i < $sectionsNumber; $i++){
            $data = array(
                [
                    'name'=> $faker->word,
                    'menu_id' => 1,
                    'created_at' => new DateTime(),
                    'updated_at' => new DateTime()
                ]
            );
            Section::insert($data);
        }
    }
}
