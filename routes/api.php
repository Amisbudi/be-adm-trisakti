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

// Examp Type
Route::get('/examType', 'ADM\StudentAdmission\ReadController@GetExamType');
Route::post('/examType', 'ADM\StudentAdmission\CreateController@InsertExamType');
Route::put('/examType/{id}', 'ADM\StudentAdmission\UpdateController@UpdateExamType');
Route::delete('/examType/{id}', 'ADM\StudentAdmission\DeleteController@DeleteExamType');

// Selection Categori
Route::get('/selectionCategory', 'ADM\StudentAdmission\ReadController@GetSelectionCategory');
Route::post('/selectionCategory', 'ADM\StudentAdmission\CreateController@InsertSelectionCategory');
Route::put('/selectionCategory/{id}', 'ADM\StudentAdmission\UpdateController@UpdateSelectionCategory');
Route::delete('/selectionCategory/{id}', 'ADM\StudentAdmission\DeleteController@DeleteSelectionCategory');





