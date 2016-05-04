<?php

namespace App\Http\Controllers;

use App\Utils\Transformers\PackRestaurantTransformer;
use App\Http\Requests;
use App\Restaurant;

define('SEARCH_RADIUS', 7000);
define('RESULTS_NUMBER', 20);
define('MAX_PACK_PER_RESTAURANT', 3);

class PackController extends ApiController
{

    private $packRestaurantTransformer;

    public function __construct()
    {
        $this->packRestaurantTransformer = new PackRestaurantTransformer();
        $this->middleware('auth', ['only' => 'post']);
    }

    public function findByLocationAndBudget($latitude, $longitude, $budgetMin, $budgetMax){
        $candidates = $this->getRestaurantsByLocation($latitude, $longitude, SEARCH_RADIUS);
        $restaurantsWithPacks = array();
        foreach($candidates as $current){
            $packs = $this->getPacksByBudget($current, $budgetMin, $budgetMax);
            if( count($packs) > 0 ){
                $current['packs'] = $packs;
                $restaurantsWithPacks[] = $this->packRestaurantTransformer->transform( $current );
            }
        }
        if( count($restaurantsWithPacks) ){
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
        $restaurants = Restaurant::with('menus.sections.elements')
            ->where('latitude','>=',$constraints['min_lat'])
            ->where('latitude','<=',$constraints['max_lat'])
            ->where('longitude','>=',$constraints['min_lng'])
            ->where('longitude','<=',$constraints['max_lng'])->get();
        $restaurantsInArea = array();
        foreach($restaurants->toArray() as $restaurant){
            if( distance($restaurant['latitude'], $restaurant['longitude'], $latitude, $longitude) < SEARCH_RADIUS ){
                $restaurantsInArea[] = $restaurant;
            }
            if( count($restaurantsInArea) == RESULTS_NUMBER){
                break;
            }
        }
        return $restaurantsInArea;
    }

    /**
     * Acaba de morir Code Complete, TODO: Refactorizar y si es posible, optimizar
     * @param $restaurant
     * @param $budgetMin
     * @param $budgetMax
     * @return array
     */
    private function getPacksByBudget($restaurant, $budgetMin, $budgetMax){
        $elements = $this->getElementsByMaxBudget($restaurant, $budgetMax);
        if(count($elements) == 0){
            return [];
        }
        $packs = array();

        $beveragesAvailable = isset($elements['bebida']) && count($elements['bebida'])>0;
        $foodsAvailable = isset($elements['comida']) && count($elements['comida'])>0;
        $complementsAvailable = isset($elements['complemento']) && count($elements['complemento'])>0;
        $dessertsAvailable = isset($elements['postre']) && count($elements['postre'])>0;

        if( $beveragesAvailable && $foodsAvailable ){
            $beverages = $elements['bebida'];
            $foods = $elements['comida'];
            foreach( $beverages as $beverage ){
                foreach( $foods as $food ){
                    $packPrice = $beverage['price'] + $food['price'];
                    if( $packPrice < $budgetMax ){
                        if( $complementsAvailable ){
                            $complements = $elements['complemento'];
                            foreach( $complements as $complement ){
                                $packPrice = $beverage['price'] + $food['price'] + $complement['price'];
                                if($packPrice < $budgetMax){
                                    if( $dessertsAvailable ){
                                        $desserts = $elements['postre'];
                                        foreach( $desserts as $dessert ){
                                            $packPrice = $beverage['price'] + $food['price'] + $complement['price'] + $dessert['price'];
                                            if( $packPrice < $budgetMax && $packPrice > $budgetMin ){
                                                $packs[] = array(
                                                    'price' => $packPrice,
                                                    'name' => 'COMBO #'. (count($packs) + 1),
                                                    'description' => 'Bebida + Comida + Complemento + Postre',
                                                    'elements' => array(
                                                        $beverage, $food, $complement, $dessert
                                                    )
                                                );
                                                if( count($packs) >= MAX_PACK_PER_RESTAURANT ){
                                                    return $packs;
                                                }
                                            }
                                        }
                                    }
                                    if( $packPrice > $budgetMin ){
                                        $packs[] = array(
                                            'price' => $packPrice,
                                            'name' => 'COMBO #'. (count($packs) + 1),
                                            'description' => 'Bebida + Comida + Complemento',
                                            'elements' => array(
                                                $beverage, $food, $complement
                                            )
                                        );
                                        if( count($packs) >= MAX_PACK_PER_RESTAURANT ){
                                            return $packs;
                                        }
                                    }
                                }
                            }

                            if( $dessertsAvailable ){
                                $desserts = $elements['postre'];
                                foreach( $desserts as $dessert ){
                                    $packPrice = $beverage['price'] + $food['price'] + $dessert['price'];
                                    if( $packPrice < $budgetMax && $packPrice > $budgetMin ){
                                        $packs[] = array(
                                            'price' => $packPrice,
                                            'name' => 'COMBO #'. (count($packs) + 1),
                                            'description' => 'Bebida + Comida + Postre',
                                            'elements' => array(
                                                $beverage, $food, $dessert
                                            )
                                        );
                                        if( count($packs) >= MAX_PACK_PER_RESTAURANT ){
                                            return $packs;
                                        }
                                    }
                                }
                            }
                        }
                        if ($packPrice > $budgetMin){
                            $packs[] = array(
                                'price' => $packPrice,
                                'name' => 'COMBO #'. (count($packs) + 1),
                                'description' => 'Bebida + Comida',
                                'elements' => array(
                                    $beverage, $food
                                )
                            );
                            if( count($packs) >= MAX_PACK_PER_RESTAURANT ){
                                return $packs;
                            }
                        }
                    }
                }
            }
        }else{
            return [];
        }
        return $packs;
    }


    /**
     * OKOKOKOK Im pretty sure there is a one line equivalent for this, im just making the fool proof version to focus on packs
     * @param $restaurant
     * @return array
     */
    private function getElementsByMaxBudget($restaurant, $budgetMax){
        $menus = $restaurant['menus'];
        $restaurantElements = array();
        foreach( $menus as $menu ){
            $sections = $menu['sections'];
            foreach($sections as $section){
                $elements = $section['elements'];
                foreach($elements as $element){
                    $type = $element['type'];
                    if( floatval($element['price']) < $budgetMax ){
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
