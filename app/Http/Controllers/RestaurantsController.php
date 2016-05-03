<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
use App\Utils\Transformers\DetailedRestaurantTransformer;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Utils\Transformers\VenueTransformer;
//use App\FoursquareAPI;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Input;

define('SEARCH_RADIUS', 7000);
define('RESULTS_NUMBER', 20);

class RestaurantsController extends ApiController
{

    /**
     * @var RestaurantTransformer
     */
    protected $restaurantTransformer;
    protected $venuesTransformer;
    protected $detailedRestaurantTransformer;

    public function __construct()
    {
        $this->restaurantTransformer = new RestaurantTransformer();
        $this->detailedRestaurantTransformer = new DetailedRestaurantTransformer();
        $this->venuesTransformer = new VenueTransformer();
        $this->middleware('auth', ['only' => 'post']);
    }

    public function showfavourites(){
        $favourites = Auth::user()->restaurants;
        $result = $this->restaurantTransformer->transformCollection($favourites->toArray());
        return $this->respondFound(['data' => $result]);
    }

    public function findByLocation($latitude, $longitude){
        //$foursquareAPI = new FoursquareAPI();
        //$venues = $foursquareAPI->all($latitude, $longitude);
        $restaurants = Restaurant::all();
        $restaurantsInArea = array();
        foreach($restaurants->toArray() as $restaurant){
            if( distance($restaurant['latitude'], $restaurant['longitude'], $latitude, $longitude) < SEARCH_RADIUS ){
                $restaurantsInArea[] = $restaurant;
            }
            if( count($restaurantsInArea) == RESULTS_NUMBER){
                break;
            }
        }
        //$result = array_merge(
        //    $this->venuesTransformer->transformCollection($venues),
        //    $this->restaurantTransformer->transformCollection($restaurantsInArea)
        //);
        //if( count($result) ){
        if( count($restaurantsInArea) ){
            return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurantsInArea)]);
            //return $this->respondFound(['data' => $result]);
        }else{
            return $this->respondNotFound('Restaurants not found near you');
        }
    }

    public function findByLocationAndBudget($latitude, $longitude, $budgetMin, $budgetMax){
        $restaurants = Restaurant::where('price','>=',$budgetMin)->where('price','<=',$budgetMax)->get();
        $restaurantsInArea = array();
        foreach($restaurants->toArray() as $restaurant){
            if( distance($restaurant['latitude'], $restaurant['longitude'], $latitude, $longitude) < SEARCH_RADIUS ){
                $restaurantsInArea[] = $restaurant;
            }
            if( count($restaurantsInArea) == RESULTS_NUMBER){
                break;
            }
        }
        $result = $this->restaurantTransformer->transformCollection($restaurantsInArea);
        if( count($result) ){
            return $this->respondFound(['data' => $result]);
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

    public function store(Request $request)
    {
        $restaurant = new Restaurant;
        $restaurant->name = $request->name;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->direction = $request->direction;
        $restaurant->type = $request->type;
        $restaurant->save();
        $phone = new Phone;
        $phone->restaurant_id = $restaurant->id;
        $phone->phone = $request->phone;
        $phone->description = $request->phone_description;
        if ($request->hasFile('image')) {
            Storage::put(
                '/images/p_img_' . $restaurant->id . '.png', file_get_contents($request->file('image')->getRealPath())
            );
            $restaurant->image = url('/images/restaurant_img_'. $restaurant->id . '.png');
        }
        $restaurant->save();
        dd($restaurant);
    }
}
