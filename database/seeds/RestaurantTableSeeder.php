<?php

use App\Restaurant;
use Illuminate\Database\Seeder;
use App\FoursquareAPI;
use App\Utils\Transformers\VenueTransformer;

define('RESTAURANTS_NUMBER', 1000);

class RestaurantTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('restaurants')->delete();
        $faker = Faker\Factory::create();

        $foursquareAPI = new FoursquareAPI();
        $venuesTransformer = new VenueTransformer();

        $usedVenues = array();

        for ($i = 0; $i < RESTAURANTS_NUMBER; $i++) {

            $latitude = $faker->randomFloat(8, 20.946246, 21.035115);
            $longitude = $faker->randomFloat(8, -89.664869, -89.573056);

            $newVenueFound = false;

            try{
                $venues = $foursquareAPI->all($latitude, $longitude);

                $venueIndex = 0;
                $resultsNumber = count($venues);
                while ($venueIndex < $resultsNumber && ! $newVenueFound ) {
                    $current = $venues[$venueIndex];
                    $venueID = $current['id'];
                    $newVenueFound = !in_array($venueID, $usedVenues);
                    if ( $newVenueFound ) {
                        $currentTransformed = $venuesTransformer->transform($current);
                        Restaurant::insert(
                            [
                                'name' => $currentTransformed['name'],
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'price' => $faker->randomFloat(2, 100, 1000),
                                'direction' => $currentTransformed['address'],
                                'type' => $currentTransformed['type'],
                                'image' => $currentTransformed['image'],
                                'created_at' => new DateTime(),
                                'updated_at' => new DateTime()
                            ]
                        );
                        $usedVenues[] = $venueID;
                    } else {
                        $venueIndex++;
                    }
                }
            }catch(Exception $e){
                $newVenueFound = false;
            }



            if ( ! $newVenueFound ) {
                Restaurant::insert(
                    [
                        'name' => $faker->name,
                        'latitude' => $faker->randomFloat(8, 20.946246, 21.035115),
                        'longitude' => $faker->randomFloat(8, -89.664869, -89.573056),
                        'price' => $faker->randomFloat(2, 100, 1000),
                        'direction' => $faker->address,
                        'type' => $faker->randomElement(['infantil', 'marisco', 'bar', 'vegetariano', 'buffet']),
                        'image' => $faker->imageUrl(),
                        'created_at' => new DateTime(),
                        'updated_at' => new DateTime()
                    ]
                );
            }
        }
    }
}
