<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
use App\Schedule;
use App\Menu;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;
use Session;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Input;


class MenuController extends ApiController
{
    public function index($restaurant_id){
        $restaurant = Restaurant::find($restaurant_id);
        $menus = $restaurant->menus;
        if($menus == null){
            $menus = [];
        }

        return view('menus.index',compact('restaurant','menus'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $menu = new Menu;
            $menu->restaurant_id = Input::get('id');
            $menu->name = Input::get('name');
            $menu->save();

            // redirect
            Session::flash('message', 'Se creó el menú exitosamente ');
            return redirect()->back();
        }
    }

    public function update()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $menu = Menu::find(Input::get('id'));
            $menu->name = Input::get('name');
            $menu->save();

            // redirect
            Session::flash('message', 'Se creó el menú exitosamente ');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        // delete
        $menu = Menu::find($id);
        $menu->delete();

        // redirect
        Session::flash('message', 'Se eliminó el menú exitosamente!');
        return redirect()->back();
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
        $menu = Menu::find($id);

        // show the view and pass the restaurant to it
        return view('menus.show',compact('menu'));
    }


}