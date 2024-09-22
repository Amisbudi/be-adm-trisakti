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
Route::put('/documentcategories', 'ADM\StudentAdmission\UpdateController@UpdateDocumentCategories');
Route::delete('/documentcategories', 'ADM\StudentAdmission\DeleteController@DeleteDocumentCategories');

Route::get('/selectioncategories', 'ADM\StudentAdmission\ReadController@GetSelectionCategories');
Route::post('/selectioncategories', 'ADM\StudentAdmission\CreateController@InsertSelectionCategories');
Route::put('/selectioncategories', 'ADM\StudentAdmission\UpdateController@UpdateSelectionCategories');
Route::delete('/selectioncategories', 'ADM\StudentAdmission\DeleteController@DeleteSelectionCategories');

Route::get('/educationmajors', 'ADM\StudentAdmission\ReadController@GetStudentInterest');
Route::post('/educationmajors', 'ADM\StudentAdmission\CreateController@InsertStudentInterest');
Route::put('/educationmajors', 'ADM\StudentAdmission\UpdateController@UpdateStudentInterest');
Route::delete('/educationmajors', 'ADM\StudentAdmission\DeleteController@DeleteStudentInterest');

Route::get('/educationdegrees', 'ADM\StudentAdmission\ReadController@GetEducationDegree');
Route::post('/educationdegrees', 'ADM\StudentAdmission\CreateController@InsertEducationDegree');
Route::put('/educationdegrees', 'ADM\StudentAdmission\UpdateController@UpdateEducationDegree');
Route::delete('/educationdegrees', 'ADM\StudentAdmission\DeleteController@DeleteEducationDegree');

Route::get('/studyprogram', 'ADM\StudentAdmission\ReadController@GetStudyProgram');
Route::post('/studyprogram', 'ADM\StudentAdmission\CreateController@InsertStudyProgram');
Route::put('/studyprogram', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgram');
Route::delete('/studyprogram', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgram');

// Category
Route::get('/categories', 'ADM\StudentAdmission\ReadController@GetCategories');
Route::post('/categories', 'ADM\StudentAdmission\CreateController@InsertCategory');
Route::put('/categories', 'ADM\StudentAdmission\UpdateController@UpdateCategory');
Route::delete('/categories', 'ADM\StudentAdmission\DeleteController@DeleteCategory');

// Form
Route::get('/forms', 'ADM\StudentAdmission\ReadController@GetForms');
Route::post('/forms', 'ADM\StudentAdmission\CreateController@InsertForm');
Route::put('/forms', 'ADM\StudentAdmission\UpdateController@UpdateForm');
Route::delete('/forms', 'ADM\StudentAdmission\DeleteController@DeleteForm');


// Schedule
Route::get('/schedules', 'ADM\StudentAdmission\ReadController@GetSchedules');
Route::post('/schedules', 'ADM\StudentAdmission\CreateController@InsertSchedule');
Route::put('/schedules', 'ADM\StudentAdmission\UpdateController@UpdateSchedule');
Route::delete('/schedules', 'ADM\StudentAdmission\DeleteController@DeleteSchedule');

// Mapping Prodi Category
Route::get('/mappingprodicategory', 'ADM\StudentAdmission\ReadController@GetMappingProdiCategory');
Route::post('/mappingprodicategory', 'ADM\StudentAdmission\CreateController@InsertMappingProdiCategory');
Route::put('/mappingprodicategory', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiCategory');
Route::delete('/mappingprodicategory', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiCategory');

// Mapping Prodi Formulir
Route::get('/mappingprodiformulir', 'ADM\StudentAdmission\ReadController@GetMappingProdiFormulir');
Route::post('/mappingprodiformulir', 'ADM\StudentAdmission\CreateController@InsertMappingProdiFormulir');
Route::put('/mappingprodiformulir', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiFormulir');
Route::delete('/mappingprodiformulir', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiFormulir');
