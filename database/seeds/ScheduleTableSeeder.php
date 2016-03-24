<?php

use App\Schedule;
use Illuminate\Database\Seeder;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = array(
            'hour_init' => rand(0,23),
            'hour_finish' => rand(0,23),
            'day' => $faker->randomElement(['Monday', 'Thursday', 'Wednesday', 'Tuesday', 'Friday', 'Saturday', 'Sunday']),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime()
        );
        $schedule = Schedule::create($data);
        $schedule->restaurants()->attach(1);
    }
}
