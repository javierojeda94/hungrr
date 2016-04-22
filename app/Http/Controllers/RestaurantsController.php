<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Utils\Transformers\DetailedRestaurantTransformer;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Utils\Transformers\VenueTransformer;
use App\FoursquareAPI;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Input;

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

    public function findByLocationAndBudget($latitude, $longitude, $budgetMin, $budgetMax){
        $restaurants = Restaurant::where('price','>=',$budgetMin)->where('price','<=',$budgetMax)->get();
        $restaurantsInArea = array();
        foreach($restaurants->toArray() as $restaurant){
            if( distance($restaurant->latitude, $restaurant->longitude, $latitude, $longitude) < SEARCH_RADIUS ){
                $restaurantsInArea[] = $restaurant;
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

    public function favorite($restaurantID){
        $result = Auth::user()->restaurants()->attach($restaurantID);
        return $this->respondCreated('Favorite Successfull ' . $result);
    }

    public function unfavorite($restaurantID){
        $result = Auth::user()->restaurants()->detach($restaurantID);
        return $this->respondCreated('Unfavorite Successfull ' . $result);
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
