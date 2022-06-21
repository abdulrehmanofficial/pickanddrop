<?php

use Illuminate\Http\Request;

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

// User Routes
Route::post('/register', 'UserController@registerApiUser');
Route::post('/is-user-exist', 'UserController@isUserExist');
Route::post('/login', 'UserController@loginUser');
Route::post('/forget-password', 'UserController@forgetPassword');
Route::post('/change-password', 'UserController@changePassword');
Route::post('/submit-driver-documents', 'UserController@submitDriverDocuments');
Route::post('/get-driver-data', 'UserController@getDriverData');
Route::post('/update-profile', 'UserController@updateProfile');

// Institute Routes
Route::post('/add-institute', 'InstituteController@addInstitute');
Route::post('/delete-institute', 'InstituteController@deleteInstitute');
Route::get('/get-institutes', 'InstituteController@getInstitutes');
Route::post('/get-driver-institutes', 'InstituteController@getDriverInstitutes');
Route::post('/search-drivers', 'InstituteController@searchDrivers');
Route::post('/request-driver', 'InstituteController@requestDriver');
Route::post('/driver-requests', 'InstituteController@driverRequests');
Route::post('/user-requests', 'InstituteController@userRequests');
Route::post('/change-request-status', 'InstituteController@changeRequestStatus');

// Trip Routes
Route::post('/start-trip', 'InstituteController@startTrip');
Route::post('/end-trip', 'InstituteController@endTrip');
Route::post('/start-tracking', 'InstituteController@startTracking');
Route::post('/set-live-location', 'InstituteController@setLiveLocation');
Route::post('/set-driver-schedule', 'InstituteController@setDriverSchedule');
Route::post('/get-driver-schedule', 'InstituteController@getDriverSchedule');
Route::post('/add-rating', 'InstituteController@addRating');
Route::post('/get-ratings', 'InstituteController@getRatings');
