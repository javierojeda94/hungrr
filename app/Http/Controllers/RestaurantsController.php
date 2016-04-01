<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;
use App\Utils\Transformers\VenueTransformer;
use App\FoursquareAPI;

class RestaurantsController extends ApiController
{

    /**
     * @var RestaurantTransformer
     */
    protected $restaurantTransformer;
    protected $venuesTransformer;

    public function __construct()
    {
        $this->restaurantTransformer = new RestaurantTransformer();
        $this->venuesTransformer = new VenueTransformer();
        $this->middleware('auth', ['only' => 'post']);
    }


    public function findByLocation($latitude, $longitude){
        $foursquareAPI = new FoursquareAPI();
        $venues = $foursquareAPI->all($latitude, $longitude);
        $restaurants = Restaurant::all();
        $result = array_merge(
            $this->venuesTransformer->transformCollection($venues),
            $this->restaurantTransformer->transformCollection($restaurants->toArray())
        );
        if( count($result) ){
            return $this->respondFound(['data' => $result]);
        }else{
            return $this->respondNotFound('Restaurants not found near you');
        }
    }

    public function index()
    {
        $restaurants = Restaurant::all();
        return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurants->toArray())]);
    }

    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        if( $restaurant ) {
            return $this->respondFound(['data' => $this->restaurantTransformer->transform($restaurant)]);
        }else{
            return $this->respondNotFound('Restaurant not found');
        }
    }

    public function store()
    {
        dd('store');
    }
}
