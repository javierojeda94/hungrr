<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Utils\Transformers\DetailedRestaurantTransformer;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

define('SEARCH_RADIUS', 7000);
define('RESULTS_NUMBER', 20);
define('DISTANCE_FUNCTION', "( 6371 * acos( cos( radians(%f) ) * cos( radians( latitude ) ) 
   * cos( radians(longitude) - radians(%f)) + sin(radians(%f)) 
   * sin( radians(latitude)))) AS distance ");

class RestaurantsController extends ApiController
{
    protected $restaurantTransformer;
    protected $detailedRestaurantTransformer;

    public function __construct()
    {
        $this->restaurantTransformer = new RestaurantTransformer();
        $this->detailedRestaurantTransformer = new DetailedRestaurantTransformer();
        $this->middleware('auth', ['only' => 'post']);
    }

    public function showfavourites(){
        $favourites = Auth::user()->restaurants;
        $result = $this->restaurantTransformer->transformCollection($favourites->toArray());
        return $this->respondFound(['data' => $result]);
    }

    public function findByLocation($latitude, $longitude){
        $constraints = getConstraints($latitude, $longitude, SEARCH_RADIUS);
        $distanceFuntion = sprintf(DISTANCE_FUNCTION, $latitude, $longitude, $latitude);

        $restaurants = Restaurant::select('*', DB::raw($distanceFuntion))
            ->where('latitude','>=',$constraints['min_lat'])
            ->where('latitude','<=',$constraints['max_lat'])
            ->where('longitude','>=',$constraints['min_lng'])
            ->where('longitude','<=',$constraints['max_lng'])
        ->orderBy('distance', 'ASC')
        ->limit(RESULTS_NUMBER)->offset(0)->get();

        if( count( $restaurants ) ){
            return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurants->toArray())]);
        }else{
            return $this->respondNotFound('Restaurants not found near you');
        }
    }

    public function findByLocationAndBudget($latitude, $longitude, $budgetMin, $budgetMax){
        $constraints = getConstraints($latitude, $longitude, SEARCH_RADIUS);
        $distanceFuntion = sprintf(DISTANCE_FUNCTION, $latitude, $longitude, $latitude);

        $restaurants = Restaurant::select('*', DB::raw($distanceFuntion))
            ->where('price','>=',$budgetMin)
            ->where('price','<=',$budgetMax)
            ->where('latitude','>=',$constraints['min_lat'])
            ->where('latitude','<=',$constraints['max_lat'])
            ->where('longitude','>=',$constraints['min_lng'])
            ->where('longitude','<=',$constraints['max_lng'])
            ->orderBy('distance', 'ASC')
            ->limit(RESULTS_NUMBER)->offset(0)->get();

        if( count( $restaurants ) ){
            return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurants->toArray())]);
        }else{
            return $this->respondNotFound('Restaurants not found near you');
        }
    }

    public function index(){
        $restaurants = Restaurant::all();
        return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurants->toArray())]);
    }

    public function show($restaurantID)
    {
        $restaurant = Restaurant::with('menus.sections.elements')->where('id','=', $restaurantID)->get()->first();
        if( $restaurant ) {
            return $this->respondFound(['data' => $this->detailedRestaurantTransformer->transform($restaurant)]);
        }else{
            return $this->respondNotFound('Restaurant not found');
        }
    }

    public function favourite($restaurantID){
        try{
            Auth::user()->restaurants()->attach($restaurantID);
        }catch(QueryException $queryException){
            return $this->respondWithConflict('User already has that favourite!');
        }
        return $this->respondCreated('Favourite successfully added!');
    }

    public function unfavourite($restaurantID){
        Auth::user()->restaurants()->detach($restaurantID);
        return $this->respondCreated('Favourite successfully removed!');
    }
}
