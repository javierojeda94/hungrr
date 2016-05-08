<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
use App\Http\Requests;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Input;


class RestaurantsWebController extends ApiController
{

    public function __construct(){

      //  $this->middleware('auth', ['only' => 'post']);
    }

    public function index(){
        //TODO: Only return users restaurants
        $restaurants = Restaurant::all();
        return view('restaurants.index',compact('restaurants'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(){
        //
        // load the create form (app/views/nerds/create.blade.php)
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request){
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($restaurantID){
        $restaurant = Restaurant::with('menus.sections.elements')->where('id','=', $restaurantID)->get()->first();
        if( $restaurant ) {
            return $this->respondFound(['data' => $this->detailedRestaurantTransformer->transform($restaurant)]);
        }else{
            return $this->respondNotFound('Restaurant not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
        //
    }
  

    public function addRestaurant(){
        return view('add_restaurant');
    }       


}
