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
Route::get('/documentcategories', 'ADM\StudentAdmission\ReadController@GetDocumentCategories');
Route::post('/documentcategories', 'ADM\StudentAdmission\CreateController@InsertDocumentCategories');
Route::put('/documentcategories/{id}', 'ADM\StudentAdmission\UpdateController@UpdateDocumentCategories');
Route::delete('/documentcategories/{id}', 'ADM\StudentAdmission\DeleteController@DeleteDocumentCategories');
Route::get('/selectioncategories', 'ADM\StudentAdmission\ReadController@GetSelectionCategories');
Route::post('/selectioncategories', 'ADM\StudentAdmission\CreateController@InsertSelectionCategories');
Route::put('/selectioncategories/{id}', 'ADM\StudentAdmission\UpdateController@UpdateSelectionCategories');
Route::delete('/selectioncategories/{id}', 'ADM\StudentAdmission\DeleteController@DeleteSelectionCategories');
Route::get('/studentinterest', 'ADM\StudentAdmission\ReadController@GetStudentInterest');
Route::post('/studentinterest', 'ADM\StudentAdmission\CreateController@InsertStudentInterest');
Route::put('/studentinterest/{id}', 'ADM\StudentAdmission\UpdateController@UpdateStudentInterest');
Route::delete('/studentinterest/{id}', 'ADM\StudentAdmission\DeleteController@DeleteStudentInterest');



