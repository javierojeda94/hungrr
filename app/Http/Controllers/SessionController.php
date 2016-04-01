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
      $user->password = 'hungrr.'.str_random(10).'.fb';
      $user->save();
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
      $password = $request->password;
      if (Auth::attempt(['email' => $email, 'password' => $password])) {
        $user = Auth::user();
        return $this->respondFound(['token' => '1i2b3k32tc56jy5c89j7y8ct9ku4v21kuc3']);
      }
      else{
        return $this->respondNotAuthorized();
      }
  }

}
