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
        if($path === 'api/v1/signup' || $path === 'api/v1/login'){
            return $next($request);
        }
        $auth_token = $request->header('Authorization');
        $user = User::where('auth_token',$auth_token)->first();
        if($user !== null && $auth_token === $user->auth_token){
            return $next($request);
        }
        else{
            return response()->json([
                'error' => [
                    'message' => 'Token error!',
                    'status_code' => '403'
                ]
            ])->header('Content-Type', 'application/json');;
        }
    }
}
