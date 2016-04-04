<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use App\User;
class SessionController extends ApiController
{
    /**
    * signup method
    * @param Request $request
    */
    public function signup(Request $request)
    {
        try{
            $user = new User;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = md5($request->password);
            $user->save();
            Auth::login($user);
            return $this->respondCreated('Usuario creado con éxito');
        } catch (\Exception $e){
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
    * login controller
    * @param Request $request
    */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = md5($request->password);
        $user = User::where('email',$email)->where('password',$password)->first();
        if ($user !== null) {
            Auth::login($user);
            return $this->respondFound(['message' => 'User authenticated!']);
        }
        else{
            return $this->respondNotAuthorized('Identification error. Check credentials and/or auth token.');
        }
    }

}
