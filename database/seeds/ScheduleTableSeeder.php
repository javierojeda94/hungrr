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
        for($i=0; $i<RESTAURANTS_NUMBER*2; $i++){
            $data = array(
                'hour_init' => rand(0,23),
                'hour_finish' => rand(0,23),
                'day' => $faker->randomElement(['Monday', 'Thursday', 'Wednesday', 'Tuesday', 'Friday', 'Saturday', 'Sunday']),
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            );
            $schedule = Schedule::create($data);
            if( $i < RESTAURANTS_NUMBER){
                $schedule->restaurants()->attach($i+1);
            }else{
                $schedule->restaurants()->attach($i + 1 - RESTAURANTS_NUMBER);
            }
        }
    }
}
