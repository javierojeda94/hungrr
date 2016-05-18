<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;
use Session;
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
        $restaurants = Auth::user()->restaurants;
        if($restaurants == null){
            $restaurants = [];
        }

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
    public function store(){
        $restaurant = new Restaurant;
        $restaurant->name = Input::get('name');
        $restaurant->direction = Input::get('direction');
        $restaurant->type = Input::get('type');
        $restaurant->save();

        $phone = new Phone;
        $phone->restaurant_id = $restaurant->id;
        $phone->phone = Input::get('phone');
        $phone->save();
        if (Input::file('image')->isValid()) {
            Storage::put(
                '/images/p_img_' . $restaurant->id . '.png', file_get_contents(Input::file('image')->getRealPath())
            );
            $restaurant->image = url('/images/restaurant_img_'. $restaurant->id . '.png');
        }
        $restaurant->save();

        Auth::user()->restaurants()->save($restaurant);
        Auth::user()->save();
        return redirect('restaurants');
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
    public function destroy($id)
    {
        // delete
        $restaurant = Restaurant::find($id);
        $restaurant->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the restaurant!');
        return redirect('restaurants');
    }



}
