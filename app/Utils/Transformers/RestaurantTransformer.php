<?php
/**
 * Created by PhpStorm.
 * User: PIX
 * Date: 24/03/2016
 * Time: 01:23 AM
 */

namespace App\Utils\Transformers;

use App\Restaurant;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

define('QUERY_RESTAURANT_AVG_PRICE',
'SELECT
	AVG(elements.price) as avg_price
FROM
	restaurants
	JOIN menus on menus.restaurant_id = restaurants.id
	JOIN sections ON sections.menu_id = menus.id
	JOIN elements ON elements.section_id = sections.id
WHERE
	restaurants.id = %d;');
define('DEFAULT_AVG_PRICE', 0.0);
define('FIRST', 0);

class RestaurantTransformer extends Transformer
{

    public function transform($restaurant)
    {
        return [
            'id' => $restaurant['id'],
            'name' => $restaurant['name'],
            'latitude' => $restaurant['latitude'],
            'longitude' => $restaurant['longitude'],
            'address' => $restaurant['direction'],
            'type' => $restaurant['type'],
            'image' => $restaurant['image'],
            'is_favorite' => $this->isFavorite($restaurant['id']),
            'source' => 'hungrr',
            'avg_price' => $this->getAveragePrice($restaurant['id']),
            'phone_numbers' => $this->getPhoneNumber($restaurant['id']),
            'schedules' => $this->getSchedule($restaurant['id'])
        ];

    }

    private function isFavorite($restaurantID){
        $restaurant = Auth::user()->restaurants()->where('restaurant_id','=',$restaurantID)->first();
        return $restaurant != null;
    }

    private function getAveragePrice($restaurantID){
        $result = DB::select(DB::raw(sprintf(QUERY_RESTAURANT_AVG_PRICE, $restaurantID)));
        $averagePrice = $result[FIRST]->avg_price;
        $restaurantHasMenus = $averagePrice!=null;

        if( $restaurantHasMenus ){
            return $averagePrice + 0.0; //return the float casted price
        }else{
            return DEFAULT_AVG_PRICE;
        }
    }

    private function getPhoneNumber($restaurantID){

    }

    private function getSchedule($restaurantID){

    }
}