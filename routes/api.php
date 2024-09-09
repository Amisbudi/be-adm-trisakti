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

Route::get('/educationmajors', 'ADM\StudentAdmission\ReadController@GetStudentInterest');
Route::post('/educationmajors', 'ADM\StudentAdmission\CreateController@InsertStudentInterest');
Route::put('/educationmajors/{id}', 'ADM\StudentAdmission\UpdateController@UpdateStudentInterest');
Route::delete('/educationmajors/{id}', 'ADM\StudentAdmission\DeleteController@DeleteStudentInterest');

Route::get('/educationdegrees', 'ADM\StudentAdmission\ReadController@GetEducationDegree');
Route::post('/educationdegrees', 'ADM\StudentAdmission\CreateController@InsertEducationDegree');
Route::put('/educationdegrees/{id}', 'ADM\StudentAdmission\UpdateController@UpdateEducationDegree');
Route::delete('/educationdegrees/{id}', 'ADM\StudentAdmission\DeleteController@DeleteEducationDegree');

Route::get('/studyprogram', 'ADM\StudentAdmission\ReadController@GetStudyProgram');
Route::post('/studyprogram', 'ADM\StudentAdmission\CreateController@InsertStudyProgram');
Route::put('/studyprogram/{id}', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgram');
Route::delete('/studyprogram/{id}', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgram');

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

