<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/images/{filename}', function ($filename) {
    $path = storage_path() . '/app/images/' . $filename;

    $file = File::get($path);
    /* fix used while we enable finfo_file php function in cpanel */
    $type = 'image/png'; //File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::auth();
    Route::get('/home', 'HomeController@index');
});

// , 'middleware' => 'api'

Route::group(['prefix'=>'api/v1', 'middleware' => 'api'], function(){
    // Session
    Route::post('signup','SessionController@signup');
    Route::post('login','SessionController@login');
    // Restaurants
    Route::resource('restaurants', 'RestaurantsController');
    Route::get('restaurants/{latitude}/{longitude}', 'RestaurantsController@findByLocation');
    Route::get('restaurants/{latitude}/{longitude}/{budgetMin}/{budgetMax}', 'RestaurantsController@findByLocationAndBudget');
    Route::get('restaurant/details/{restaurantID}', 'RestaurantsController@show');
    Route::get('restaurant/favorite/{restaurantID}', 'RestaurantsController@favorite');
    Route::get('restaurant/unfavorite/{restaurantID}', 'RestaurantsController@unfavorite');
});
