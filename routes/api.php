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
Route::post('/examType/{id}', 'ADM\StudentAdmission\UpdateController@UpdateExamType');
Route::post('/examType/{id}', 'ADM\StudentAdmission\DeleteController@DeleteExamType');

// Selection Categori
Route::get('/selectionCategory', 'ADM\StudentAdmission\ReadController@GetSelectionCategory');
Route::post('/selectionCategory', 'ADM\StudentAdmission\CreateController@InsertSelectionCategory');
Route::post('/selectionCategory/{id}', 'ADM\StudentAdmission\UpdateController@UpdateSelectionCategory');
Route::post('/selectionCategory/{id}', 'ADM\StudentAdmission\DeleteController@DeleteSelectionCategory');

Route::get('/documentcategories', 'ADM\StudentAdmission\ReadController@GetDocumentCategories');
Route::post('/documentcategories', 'ADM\StudentAdmission\CreateController@InsertDocumentCategories');
Route::post('/documentcategories', 'ADM\StudentAdmission\UpdateController@UpdateDocumentCategories');
Route::post('/documentcategories', 'ADM\StudentAdmission\DeleteController@DeleteDocumentCategories');

Route::get('/selectioncategories', 'ADM\StudentAdmission\ReadController@GetSelectionCategories');
Route::post('/selectioncategories', 'ADM\StudentAdmission\CreateController@InsertSelectionCategories');
Route::post('/selectioncategories', 'ADM\StudentAdmission\UpdateController@UpdateSelectionCategories');
Route::post('/selectioncategories', 'ADM\StudentAdmission\DeleteController@DeleteSelectionCategories');

Route::get('/educationmajors', 'ADM\StudentAdmission\ReadController@GetStudentInterest');
Route::post('/educationmajors', 'ADM\StudentAdmission\CreateController@InsertStudentInterest');
Route::post('/educationmajors', 'ADM\StudentAdmission\UpdateController@UpdateStudentInterest');
Route::post('/educationmajors', 'ADM\StudentAdmission\DeleteController@DeleteStudentInterest');

Route::get('/educationdegrees', 'ADM\StudentAdmission\ReadController@GetEducationDegree');
Route::post('/educationdegrees', 'ADM\StudentAdmission\CreateController@InsertEducationDegree');
Route::post('/educationdegrees', 'ADM\StudentAdmission\UpdateController@UpdateEducationDegree');
Route::post('/educationdegrees', 'ADM\StudentAdmission\DeleteController@DeleteEducationDegree');

Route::get('/studyprogram', 'ADM\StudentAdmission\ReadController@GetStudyProgram');
Route::post('/studyprogram', 'ADM\StudentAdmission\CreateController@InsertStudyProgram');
Route::post('/studyprogram', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgram');
Route::post('/studyprogram', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgram');

// Category
Route::get('/categories', 'ADM\StudentAdmission\ReadController@GetCategories');
Route::post('/categories', 'ADM\StudentAdmission\CreateController@InsertCategory');
Route::post('/categories', 'ADM\StudentAdmission\UpdateController@UpdateCategory');
Route::post('/categories', 'ADM\StudentAdmission\DeleteController@DeleteCategory');

// Form
Route::get('/forms', 'ADM\StudentAdmission\ReadController@GetForms');
Route::post('/forms', 'ADM\StudentAdmission\CreateController@InsertForm');
Route::post('/forms', 'ADM\StudentAdmission\UpdateController@UpdateForm');
Route::post('/forms', 'ADM\StudentAdmission\DeleteController@DeleteForm');

// Schedule
Route::get('/schedules', 'ADM\StudentAdmission\ReadController@GetSchedules');
Route::post('/schedules', 'ADM\StudentAdmission\CreateController@InsertSchedule');
Route::post('/schedules', 'ADM\StudentAdmission\UpdateController@UpdateSchedule');
Route::post('/schedules', 'ADM\StudentAdmission\DeleteController@DeleteSchedule');

// Mapping Prodi Category
Route::get('/mappingprodicategory', 'ADM\StudentAdmission\ReadController@GetMappingProdiCategory');
Route::post('/mappingprodicategory', 'ADM\StudentAdmission\CreateController@InsertMappingProdiCategory');
Route::post('/mappingprodicategory', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiCategory');
Route::post('/mappingprodicategory', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiCategory');

// Mapping Prodi Formulir
Route::get('/mappingprodiformulir', 'ADM\StudentAdmission\ReadController@GetMappingProdiFormulir');
Route::post('/mappingprodiformulir', 'ADM\StudentAdmission\CreateController@InsertMappingProdiFormulir');
Route::post('/mappingprodiformulir', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiFormulir');
Route::post('/mappingprodiformulir', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiFormulir');

// Mapping Master Mata Pelajaran
Route::get('/masterMataPelajaran', 'ADM\StudentAdmission\ReadController@GetMasterMataPelajaran');
Route::post('/masterMataPelajaran', 'ADM\StudentAdmission\CreateController@InsertMasterMataPelajaran');
Route::post('/masterMataPelajaran/{id}', 'ADM\StudentAdmission\UpdateController@UpdateMasterMataPelajaran');
Route::post('/masterMataPelajaran/{id}', 'ADM\StudentAdmission\DeleteController@DeleteMasterMataPelajaran');

// Mapping Master Kelas
Route::get('/masterKelas', 'ADM\StudentAdmission\ReadController@GetStudyProgramSpecialization');
Route::post('/masterKelas', 'ADM\StudentAdmission\CreateController@InsertStudyProgramSpecialization');
Route::post('/masterKelas/{id}', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgramSpecialization');
Route::post('/masterKelas/{id}', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgramSpecialization');