<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'groups'], function () {
        Route::get('', 'GroupController@index');
        Route::post('', 'GroupController@store')
            ->middleware('can:store,App\Group')
        ;
        Route::get('{group}', 'GroupController@show')
            ->middleware('can:show,group')
        ;
        Route::put('{group}', 'GroupController@update')
            ->middleware('can:update,group')
        ;
        Route::delete('{group}', 'GroupController@destroy')
            ->middleware('can:destroy,group')
        ;
        Route::post('join_request', 'GroupController@joinRequest');
        Route::post('join_accept/{user}/{group}', 'GroupController@joinAccept')
            ->middleware('can:joinAccept,group,user')
        ;
        Route::post('join_reject/{user}/{group}', 'GroupController@joinReject')
            ->middleware('can:joinReject,group,user')
        ;
        Route::post('leave/{group}', 'GroupController@leave')
            ->middleware('can:leave,group,user')
        ;
    });
    Route::group(['prefix' => 'events'], function () {
        Route::post('/{group}', 'EventController@store');
    });
});
