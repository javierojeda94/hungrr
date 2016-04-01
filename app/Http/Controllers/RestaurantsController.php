<?php

namespace App\Http\Controllers;

use Jcroll\FoursquareApiClient\Client\FoursquareClient;
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
        //$restaurants = Restaurant::all();
        //return $this->respondFound(['data' => $this->restaurantTransformer->transformCollection($restaurants->toArray())]);
        
        $client = FoursquareClient::factory(array(
            'client_id'     => 'DA1CVJNBDE2O4KP11O1Z01ACSUICGAT1QY4KZFIC40MT25QI',    // required
            'client_secret' => 'WAQT0FHFMDIJ15Q01EPQNMUV02CWUFWGT2F2AVYOQTQZBLVZ' // required
        ));
        $command = $client->getCommand('venues/search', array(
            'llAcc' => 1000,
            'll' => '21.041252,-89.647359',
            'section' => 'food,drinks,coffe',
            'sortByDistance' => 1,
            'limit' => 15,
            'radius' => 7500,
            'openNow' => 1,
            'venuePhotos' => 1,
            'offset' => 0, //Pagination porpouses
            'query' => '' //Especific type of food ex. Donuts, Frijol etc xD


        ));
        $results = $command->execute(); // returns an array of results
        return $results;
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
