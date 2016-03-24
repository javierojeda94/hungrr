<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(RestaurantTableSeeder::class);
        $this->call(ScheduleTableSeeder::class);
        $this->call(OwnerTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(SectionTableSeeder::class);
        $this->call(ElementTableSeeder::class);
        Model::reguard();
    }
}
