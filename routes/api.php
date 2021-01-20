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
    Route::apiResource('groups', 'GroupController');
    Route::group(['prefix' => 'participants'], function () {
        Route::post('request', 'ParticipantController@request');
        Route::delete('leave/{group}', 'ParticipantController@leave');
    });
});
