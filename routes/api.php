<?php

// use Illuminate\Http\Request;

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

Route::get('af3ac15a0392e10afbf3feb197ffed24/{id}', 'ADM\StudentAdmission\CreateController@Verifymail')->name('af3ac15a0392e10afbf3feb197ffed24');
Route::get('4e374a7443c209ffcdcb722eb1b0e989/{id}/{token}', 'ADM\StudentAdmission\CreateController@ReturnPageResetPassword')->name('4e374a7443c209ffcdcb722eb1b0e989');

// Category
Route::get('/categories', 'ADM\StudentAdmission\ReadController@GetCategories');
Route::post('/categories', 'ADM\StudentAdmission\CreateController@InsertCategory');
Route::put('/categories/{id}', 'ADM\StudentAdmission\UpdateController@UpdateCategory');
Route::delete('/categories/{id}', 'ADM\StudentAdmission\DeleteController@DeleteCategory');

// Form
Route::get('/forms', 'ADM\StudentAdmission\ReadController@GetForms');
Route::post('/forms', 'ADM\StudentAdmission\CreateController@InsertForm');
Route::put('/forms/{id}', 'ADM\StudentAdmission\UpdateController@UpdateForm');
Route::delete('/forms/{id}', 'ADM\StudentAdmission\DeleteController@DeleteForm');


// Schedule
Route::get('/schedules', 'ADM\StudentAdmission\ReadController@GetSchedules');
Route::post('/schedules', 'ADM\StudentAdmission\CreateController@InsertSchedule');
Route::put('/schedules/{id}', 'ADM\StudentAdmission\UpdateController@UpdateSchedule');
Route::delete('/schedules/{id}', 'ADM\StudentAdmission\DeleteController@DeleteSchedule');

