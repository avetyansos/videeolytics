<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/login', 'AuthController@showLoginForm')->name('login');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout')->name('logout');


Route::group([
    'prefix' => 'backoffice',
    'namespace' => 'Backoffice',
    'middleware' => ['auth']
], function() {
    Route::get('/test', 'MainController@test'); // TEST action

    Route::get('/', 'MainController@index')->name('backoffice');

    //////////////////////////////////////////////////////////////////////////

    Route::resource('analytics', 'AnalyticsController')->names([
        'index' => 'backoffice.analytics',
        'show' => 'backoffice.analytics.show',
        'destroy' => 'backoffice.analytics.delete',
    ]);

});
