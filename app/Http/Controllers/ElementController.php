<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Element;
use App\Section;
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


class ElementController extends ApiController
{
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
            'price'       => 'required',
            'description' => 'required',
            'type' => 'required',
            'image' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $element = new Element;
            $element->section_id = Input::get('id');
            $element->name = Input::get('name');
            $element->price = Input::get('price');
            $element->type = Input::get('type');
            $element->currency = 'MXN';
            $element->description = Input::get('description');
            $element->save();

            if (Input::file('image')->isValid()) {
                Storage::put(
                    '/images/element_img_' . $element->id . '.png', file_get_contents(Input::file('image')->getRealPath())
                );
                $element->image = url('/images/element_img_'. $element->id . '.png');
            }
            $element->save();


            // redirect
            Session::flash('message', 'Se creó '. $element->name .' exitosamente');
            return redirect()->back();
        }
    }

    public function update()
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'price'       => 'required',
            'description' => 'required',
            'type' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $element = Element::find(Input::get('id'));
            $element->name = Input::get('name');
            $element->price = Input::get('price');
            $element->type = Input::get('type');
            $element->currency = 'MXN';
            $element->description = Input::get('description');
            $element->save();

            if(Input::file('image')!= null){
                if (Input::file('image')->isValid()) {
                    Storage::put(
                        '/images/element_img_' . $element->id . '.png', file_get_contents(Input::file('image')->getRealPath())
                    );
                    $element->image = url('/images/element_img_' . $element->id . '.png');
                }
            }

            $element->save();

            // redirect
            Session::flash('message', 'Se editó ' . $element->name . ' exitosamente');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        // delete
        $element = Element::find($id);
        $element->delete();

        // redirect
        Session::flash('message', 'Se eliminó el menú exitosamente!');
        return redirect()->back();
    }
}