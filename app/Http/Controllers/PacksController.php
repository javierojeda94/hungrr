<?php

namespace App\Http\Controllers;

use App\Utils\Transformers\PackRestaurantTransformer;
use App\Http\Requests;
use App\Restaurant;
use Illuminate\Support\Facades\DB;

define('SEARCH_RADIUS', 7000);
define('RESULTS_NUMBER', 20);
define('DISTANCE_FUNCTION', "( 6371 * acos( cos( radians(%f) ) * cos( radians( latitude ) ) 
   * cos( radians(longitude) - radians(%f)) + sin(radians(%f)) 
   * sin( radians(latitude)))) AS distance ");
define('MAX_PACK_PER_RESTAURANT', 3);

class PackController extends ApiController
{

    private $packRestaurantTransformer;

    public function __construct()
    {
        $this->packRestaurantTransformer = new PackRestaurantTransformer();
        $this->middleware('auth', ['only' => 'post']);
    }

    public function findByLocationAndBudget($latitude, $longitude, $budgetMin, $budgetMax, $random){
        $restaurants = $this->getRestaurantsByLocation($latitude, $longitude, SEARCH_RADIUS);
        $restaurantsWithPacks = array();
        foreach($restaurants as $restaurant){
            $packMaker = new PackMaker($restaurant, $budgetMin, $budgetMax);
            $packs = $packMaker->getAll( MAX_PACK_PER_RESTAURANT , $random);

            $restaurantHasPacks = count($packs) > 0;

            if( $restaurantHasPacks ){
                $restaurant['packs'] = $packs;
                $restaurantsWithPacks[] = $this->packRestaurantTransformer->transform( $restaurant );
            }
        }
        if( count($restaurantsWithPacks) > 0 ){
            return $this->respondFound(['data' => $restaurantsWithPacks]);
        }else{
            return $this->respondNotFound('No Combos found with your search criteria');
        }
    }

    /**
     * Note: The extra 1000 meters are to compensate the fact that the formula expects the earth to be a perfect sphere
     * @param $latitude
     * @param $longitude
     * @param $searchRadius
     * @return array
     */
    private function getRestaurantsByLocation($latitude, $longitude, $searchRadius){
        $constraints = getConstraints($latitude, $longitude, $searchRadius + 1000);
        $distanceFuntion = sprintf(DISTANCE_FUNCTION, $latitude, $longitude, $latitude);

        $restaurants = Restaurant::select('*', DB::raw($distanceFuntion))
            ->with('menus.sections.elements')
            ->where('latitude','>=',$constraints['min_lat'])
            ->where('latitude','<=',$constraints['max_lat'])
            ->where('longitude','>=',$constraints['min_lng'])
            ->where('longitude','<=',$constraints['max_lng'])
            ->orderBy('distance', 'ASC')
            ->limit(RESULTS_NUMBER)->offset(0)->get();

        return $restaurants;
    }
}
define('MAX_INTENTS_LIMIT', 30);
class PackMaker{

    private $packs;
    private $restaurant;
    private $minBudget;
    private $maxBudget;

    public function __construct($restaurant, $minBudget, $maxBudget)
    {
        $this->restaurant = $restaurant;
        $this->minBudget = $minBudget;
        $this->maxBudget = $maxBudget;
        $this->packs = array();
    }

    public function getAll($limit = 100, $shuffle = false){
        $elements = $this->getElementsByMaxBudget();

        if(count($elements) == 0){
            return [];
        }

        $beveragesAvailable = isset($elements['bebida']) && count($elements['bebida'])>0;
        $foodsAvailable = isset($elements['comida']) && count($elements['comida'])>0;

        if(!$beveragesAvailable || !$foodsAvailable){
            return [];
        }

        if( $shuffle ){
            $this->makeRandomPacks( $elements, $limit );
        }else{
            $this->makePacks($elements, $limit);
        }

        return $this->packs;
    }


    private function makeRandomPacks($elements, $limit){

        $complementsAvailable = isset($elements['complemento']) && count($elements['complemento'])>0;
        $dessertsAvailable = isset($elements['postre']) && count($elements['postre'])>0;

        for($i=0; $i<MAX_INTENTS_LIMIT && count($this->packs)<$limit ; $i++){
            $combination = array(
                getRandomElement($elements['bebida']),
                getRandomElement($elements['comida'])
            );

            $complementSupriseFactor = rand(0,2) == 1;

            if($complementsAvailable && $complementSupriseFactor){
                $combination[] = getRandomElement($elements['complemento']);
            }

            $dessertsSupriseFactor = rand(0,2) == 1;

            if($dessertsAvailable && $dessertsSupriseFactor){
                $combination[] = getRandomElement($elements['postre']);
            }

            $this->appendPack(
                $this->get( $combination )
            );
        }
    }

    private function makePacks($elements, $limit){

        $complementsAvailable = isset($elements['complemento']) && count($elements['complemento'])>0;
        $dessertsAvailable = isset($elements['postre']) && count($elements['postre'])>0;

        for($i=0; $i<count($elements['bebida']) && count($this->packs)<$limit; $i++){
            $beverage = $elements['bebida'][$i];
            for($i=0;  $i<count($elements['comida']) && count($this->packs)<$limit; $i++){
                $food = $elements['comida'][$i];
                for($i=0; $complementsAvailable && $i<count($elements['complemento']) && count($this->packs)<$limit; $i++){
                    $complement = $elements['complemento'][$i];
                    for($i=0; $dessertsAvailable && $i<count($elements['postre']) && count($this->packs)<$limit; $i++){
                        $dessert = $elements['postre'][$i];

                        $combination = array($beverage, $food, $complement, $dessert );
                        if( !$this->appendPack( $this->get( $combination ))){

                            $combination = array($beverage, $food, $dessert );
                            $this->appendPack($this->get($combination));

                        }
                    }
                    $combination = array($beverage, $food, $complement );
                    $this->appendPack($this->get($combination));
                }
                $combination = array($beverage, $food );
                $this->appendPack($this->get($combination));
            }
        }
    }

    private function appendPack($pack){
        if( $pack != null ){
            $this->packs[] = $pack;
            return true;
        }else{
            return false;
        }
    }

    private function get($elements){
        $packPrice = 0;
        $packDescription = '';

        $elementsNumber = count($elements);
        for($i = 0 ; $i < $elementsNumber ; $i++){
            if($i != 0){
                $packDescription .= " + ";
            }
            $packPrice += $elements[$i]['price'];
            $packDescription .= $elements[$i]['type'];
        }

        if( $packPrice <= $this->maxBudget && $packPrice >= $this->minBudget ){
            return array(
                'price' => $packPrice,
                'name' => 'COMBO #'. (count($this->packs) + 1),
                'description' => $packDescription,
                'elements' => $elements
            );
        }
        return null;
    }

    private function getElementsByMaxBudget(){
        $restaurantElements = array();
        $restaurant = $this->restaurant;
        $maxBudget = $this->maxBudget;
        foreach($restaurant['menus'] as $menu){
            foreach ($menu['sections'] as $section){
                foreach ($section['elements'] as $element){
                    $type = $element['type'];
                    if( floatval($element['price']) < $maxBudget ){
                        if( !isset($restaurantElements[$type]) ){
                            $restaurantElements[$type] = array();
                        }
                        $restaurantElements[$type][] = $element;
                    }
                }
            }
        }
        return $restaurantElements;
    }

}
