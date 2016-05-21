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
    // Session
   // Route::post('registerOwner','SessionController@signupOwner');
   // Route::post('loginOwner','SessionController@loginOwner');
    Route::get('/home', 'RestaurantsWebController@index');
    Route::resource('restaurants', 'RestaurantsWebController');

    //Menus
    Route::get('/menus/{restaurantId}', 'MenuController@index');
    Route::get('/menus/edit/{menuId}', 'MenuController@show');
    Route::resource('menus', 'MenuController');
    Route::post('/menus/store',
        [ 'as' => 'menus.store',
            'uses' => 'MenuController@store'
        ]);
    Route::post('/menus/update',
        [ 'as' => 'menus.update',
            'uses' => 'MenuController@update'
        ]);

    //Sections
    Route::resource('sections', 'SectionController');
    Route::post('/section/store',
        [ 'as' => 'section.store',
            'uses' => 'SectionController@store'
        ]);
    Route::post('/section/update',
        [ 'as' => 'section.update',
            'uses' => 'SectionController@update'
        ]);

    //Elements
    Route::resource('elements', 'ElementController');
    Route::post('/element/store',
        [ 'as' => 'element.store',
            'uses' => 'ElementController@store'
        ]);
    Route::post('/element/update',
        [ 'as' => 'element.update',
            'uses' => 'ElementController@update'
        ]);

    //Messages
    Route::post('contact',
        ['as' => 'contact_store', 'uses' => 'HomeController@store']);
    Route::post('contact_request','HomeController@store');

    // Mail
    Route::get('mail/test/{message}','HomeController@mail');


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
    Route::get('packs/{latitude}/{longitude}/{budgetMin}/{budgetMax}/{random}', 'PackController@findByLocationAndBudget');
    Route::get('restaurant/details/{restaurantID}', 'RestaurantsController@show');
    Route::get('restaurant/favourite/{restaurantID}', 'RestaurantsController@favourite');
    Route::get('restaurant/unfavourite/{restaurantID}', 'RestaurantsController@unfavourite');
    Route::get('restaurant/favourites', 'RestaurantsController@showfavourites');
});
