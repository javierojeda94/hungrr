<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Phone;
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


class SectionController extends ApiController
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
        );
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $section = new Section;
            $section->menu_id = Input::get('id');
            $section->name = Input::get('name');
            $section->save();

            // redirect
            Session::flash('message', 'Se creó la sección exitosamente ');
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
            $section = Section::find(Input::get('id'));
            $section->name = Input::get('name');
            $section->save();

            // redirect
            Session::flash('message', 'Se creó el menú exitosamente ');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        // delete
        $section = Section::find($id);
        $section->delete();

        // redirect
        Session::flash('message', 'Se eliminó el menú exitosamente!');
        return redirect()->back();
    }
}