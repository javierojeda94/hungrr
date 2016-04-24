<?php

use App\User;
use Illuminate\Database\Seeder;

define('DEFAULT_EMAIL', 'user@hungrr.com.mx');
define('DEFAUL_PASSWORD', 'password');
define('DEFAUL_USERNAME', 'hungrr');

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleImagePath = 'images/users/sample_user.png';
        $faker = Faker\Factory::create();
        $data = array(
            'username' => DEFAUL_USERNAME,
            'name'=> $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => DEFAULT_EMAIL,
            'image' => $sampleImagePath,
            'password' => md5(DEFAUL_PASSWORD),
            'remember_token' => null,
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        );
        User::create($data);
    }
}
