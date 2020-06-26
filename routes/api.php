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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Api\Auth\LoginController@login');
Route::post('/create-user', 'Api\Auth\RegisterController@createUser');

Route::middleware('auth:api')
    ->namespace('Api')
    ->group(function () {
        
        Route::post('/complete-registration', 'Auth\RegisterController@completeRegistration');
        Route::post('/upload-avatar', 'User\AccountSettingController@uploadAvatar');

        Route::post('/search-donor', 'Donor\DonorController@searchDonor');
        Route::post('/rate-donor', 'Donor\DonorController@ratingDonor');

        Route::get('/me', 'User\AccountSettingController@me');
        Route::post('/logout', 'Auth\LoginController@logout');
    });
