<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Utils\Transformers\RestaurantTransformer;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Utils\Transformers\VenueTransformer;
use App\FoursquareAPI;
use Storage;
use Illuminate\Support\Facades\Input;

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

    public function index(){
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
