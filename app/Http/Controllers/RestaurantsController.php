<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;

class RestaurantsController extends ApiController
{

    /**
     * @var RestaurantTransformer
     */
    protected $restaurantTransformer;

    /**
     * RestaurantsController constructor.
     * @param RestaurantTransformer $restaurantTransformer
     */
    public function __construct(RestaurantTransformer $restaurantTransformer)
    {
        $this->restaurantTransformer = $restaurantTransformer;
        $this->middleware('auth', ['only' => 'post']);
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
