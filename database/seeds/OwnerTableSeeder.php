<?php

use App\Owner;
use Illuminate\Database\Seeder;

class OwnerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleImagePath = 'images/owner/sample_owner.png';
        $faker = Faker\Factory::create();
        $data = array(
            'name'=> $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'image' => $sampleImagePath,
            'password' => bcrypt('password'),
            'remember_token' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        );
        $owner = Owner::create($data);
        $owner->restaurants()->attach(1);
    }
}
