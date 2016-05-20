<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function store()
    {

        //Get all the data and store it inside Store Variable
        $data = Input::all();

        //Validation rules
        $rules = array (
            //'first_name' => 'required', uncomment if you want to grab this field
            //'email' => 'required|email',  uncomment if you want to grab this field
            'message' => 'required|min:5'
        );

        //Validate data
        $validator = Validator::make ($data, $rules);

        //If everything is correct than run passes.
        if ($validator -> passes()){
            Mail::raw($msg, function($message){
                //$message->from($data['email'] , $data['first_name']); uncomment if using first name and email fields
                $message->from('hungrr.mx@gmail.com', 'feedback contact form');
                //email 'To' field: cahnge this to emails that you want to be notified.
                $message->to('gennycm13@gmail.com', 'Andrea')->cc('gennycm13@gmail.com')->subject('feedback form submit');
                //email subject
                $message->subject('feedback contact form');
            });
            // Redirect to page
            return redirect('home')
                ->with('message', 'Your message has been sent. Thank You!');

        }else{
            //return contact form with errors
            return redirect('home')
                ->with('error', 'Feedback must contain more than 5 characters. Try Again.');

        }

    }


}
