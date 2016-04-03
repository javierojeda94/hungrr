<?php

namespace App\Http\Middleware;

use Closure;

use App\User;

class SessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $path = $request->path();
        if($path === 'api/v1/signup'){
            return $next($request);
        }
        $email = $request->email;
        $password = $request->password;
        $auth_token = $request->header('auth_token');
        $user = User::where('email',$email)->where('password',md5($password))->first();
        if($user !== null && $auth_token === $user->auth_token){
            return $next($request);
        }
        else{
            $error = ($user === null)? 'Wrong credentials!' : "Token error!";
            return response()->json([
                'error' => [
                    'message' => $error,
                    'status_code' => '403'
                ]
            ])->header('Content-Type', 'application/json');;
        }
    }
}
