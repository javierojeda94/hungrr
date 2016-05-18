<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
use App\Schedule;
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
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'type'      => 'required',
            'phone'      => 'required',
            'direction' => 'required',
        );
        $days = array(
            'monday', 'tuesday','wednesday','thursday','friday','saturday','sunday'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('restaurants/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            $restaurant = new Restaurant;
            $restaurant->name = Input::get('name');
            $restaurant->direction = Input::get('direction');
            $restaurant->type = Input::get('type');
            $restaurant->latitude = Input::get('us2-lat');
            $restaurant->longitude = Input::get('us2-lon');
            $restaurant->save();

            //Saving phone
            $phone = new Phone;
            $phone->restaurant_id = $restaurant->id;
            $phone->phone = Input::get('phone');
            $phone->save();
            if (Input::file('image')->isValid()) {
                Storage::put(
                    '/images/restaurant_img_' . $restaurant->id . '.png', file_get_contents(Input::file('image')->getRealPath())
                );
                $restaurant->image = url('/images/restaurant_img_'. $restaurant->id . '.png');
            }
            $restaurant->save();

            //Saving schedule
            foreach ($days as $day) {
                $schedule = new Schedule;
                $schedule->day = $day;
                $schedule->hour_init = Input::get($day.'_oh');
                $schedule->hour_finish = Input::get($day.'_ch');
                $schedule->save();
                $restaurant->schedules()->save($schedule);
            }

            Auth::user()->restaurants()->save($restaurant);
            Auth::user()->save();
        }

        return redirect('restaurants');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // get the nerd
        $restaurant = Restaurant::find($id);
        $phones = $restaurant->phones()->where('restaurant_id', $restaurant->id)->first();
        $schedules = $restaurant->schedules;

        // show the view and pass the restaurant to it
        return view('restaurants.show',compact('restaurant','phones','schedules'));
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
       // $restaurant->phones()->delete();
        $restaurant->schedules()->delete();
        $restaurant->delete();

        // redirect
        Session::flash('message', 'Se eliminó el restaurante exitosamente');
        return redirect('restaurants');
    }



}
