<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ActivityController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::apiResource('activities', 'ActivityController');
Route::apiResource('registrations', 'RegistrationController');

// Testing
Route::apiResource('users', 'UserController');
Route::apiResource('clubs', 'ClubController');
Route::group(['prefix' => 'clubs/{club}'], function () {
    Route::get('users', 'ClubController@showUsers')->name('club.users');
});
Route::get('activities/{from}/{to}', 'ActivityController@activitiesBetweenDates')->name('activities.between');
Route::post('users/club_user', 'UserController@atach_user')->name('club.user');
// END Testing

/*
Get filters
GET /activities/filters

Returns a list of the available filters this club has configured for activities
 
Get activities
GET /activities
URL parameters:
lower_date (optional): the minimum start date 
upper_date (optional): the maximum start date
filter_ids (optional): comma separated list of available filters 

Returns a list of available activities from your club

Get activity
GET /activity/<ID>

Returns a single activity

Register person for activity

POST /registration 
POST data:
activity_id (required)
first_name (required)
last_name (required)
email (optional)
phone (optional)
gender (optional)

Registers a person for the given activity id. Returns a unique ID for this registration

Unregister person
DELETE /registration/<REGISTRATION_ID>

Removes a registration 

Mark Present
PUT /registration/<ID>/presence

Mark the person ‘present’ for the given registration (‘check-in’)

Mark Absent
DELETE /registration/<ID>/presence

Mark the person ‘absent’ for the given registration (cancel ‘check-in’)

*/