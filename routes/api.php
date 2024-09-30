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
Route::post('/studyprogram/insert', 'ADM\StudentAdmission\CreateController@InsertStudyProgram');
Route::post('/studyprogram/update', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgram');
Route::post('/studyprogram/delete', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgram');

Route::get('/transfercredit', 'ADM\StudentAdmission\ReadController@GetTransferCredit');
Route::post('/transfercredit/insert', 'ADM\StudentAdmission\CreateController@InsertTransferCredit');
Route::post('/transfercredit/update', 'ADM\StudentAdmission\UpdateController@UpdateTransferCredit');
Route::post('/transfercredit/delete', 'ADM\StudentAdmission\DeleteController@DeleteTransferCredit');

// Form
Route::get('/forms', 'ADM\StudentAdmission\ReadController@GetForms');
Route::post('/forms/insert', 'ADM\StudentAdmission\CreateController@InsertForm');
Route::post('/forms/update', 'ADM\StudentAdmission\UpdateController@UpdateForm');
Route::post('/forms/delete', 'ADM\StudentAdmission\DeleteController@DeleteForm');

// Mapping Prodi Biaya
Route::get('/mappingprodibiaya', 'ADM\StudentAdmission\ReadController@GetMappingProdiBiaya');
Route::post('/mappingprodibiaya/insert', 'ADM\StudentAdmission\CreateController@InsertMappingProdiBiaya');
Route::post('/mappingprodibiaya/update', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiBiaya');
Route::post('/mappingprodibiaya/delete', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiBiaya');

// Mapping Prodi Minat
Route::get('/mappingprodiminat', 'ADM\StudentAdmission\ReadController@GetMappingProdiMinat');
Route::post('/mappingprodiminat/insert', 'ADM\StudentAdmission\CreateController@InsertMappingProdiMinat');
Route::post('/mappingprodiminat/update', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiMinat');
Route::post('/mappingprodiminat/delete', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiMinat');

// Mapping Prodi Category
Route::get('/mappingprodicategory', 'ADM\StudentAdmission\ReadController@GetMappingProdiCategory');
Route::post('/mappingprodicategory', 'ADM\StudentAdmission\CreateController@InsertMappingProdiCategory');
Route::post('/mappingprodicategory/update', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiCategory');
Route::post('/mappingprodicategory/delete', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiCategory');

// Mapping Prodi Formulir
Route::get('/mappingprodiformulir', 'ADM\StudentAdmission\ReadController@GetMappingProdiFormulir');
Route::post('/mappingprodiformulir/insert', 'ADM\StudentAdmission\CreateController@InsertMappingProdiFormulir');
Route::post('/mappingprodiformulir/update', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiFormulir');
Route::post('/mappingprodiformulir/delete', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiFormulir');

// Mapping Master Mata Pelajaran
Route::get('/masterMataPelajaran', 'ADM\StudentAdmission\ReadController@GetMasterMataPelajaran');
Route::post('/masterMataPelajaran', 'ADM\StudentAdmission\CreateController@InsertMasterMataPelajaran');
Route::post('/masterMataPelajaran/update', 'ADM\StudentAdmission\UpdateController@UpdateMasterMataPelajaran');
Route::post('/masterMataPelajaran/delete', 'ADM\StudentAdmission\DeleteController@DeleteMasterMataPelajaran');

// Mapping Master Kelas - BEDA COLUMN TABLE
Route::get('/masterKelas', 'ADM\StudentAdmission\ReadController@GetStudyProgramSpecialization');
Route::post('/masterKelas', 'ADM\StudentAdmission\CreateController@InsertStudyProgramSpecialization');
Route::post('/masterKelas/update', 'ADM\StudentAdmission\UpdateController@UpdateStudyProgramSpecialization');
Route::post('/masterKelas/delete', 'ADM\StudentAdmission\DeleteController@DeleteStudyProgramSpecialization');

// Mapping Prodi Mata Pelajaran
Route::get('/mappingprodimatapelajaran', 'ADM\StudentAdmission\ReadController@GetMappingProdiMatapelajaran');
Route::post('/mappingprodimatapelajaran/insert', 'ADM\StudentAdmission\CreateController@InsertMappingProdiMatapelajaran');
Route::post('/mappingprodimatapelajaran/update', 'ADM\StudentAdmission\UpdateController@UpdateMappingProdiMatapelajaran');
Route::post('/mappingprodimatapelajaran/delete', 'ADM\StudentAdmission\DeleteController@DeleteMappingProdiMatapelajaran');

// Package Question Users
Route::get('/packagequestionusers', 'ADM\StudentAdmission\ReadController@GetPackageQuestionUsers');
Route::post('/packagequestionusers/insert', 'ADM\StudentAdmission\CreateController@InsertPackageQuestionUsers');
Route::post('/packagequestionusers/update', 'ADM\StudentAdmission\UpdateController@UpdatePackageQuestionUsers');
Route::post('/packagequestionusers/delete', 'ADM\StudentAdmission\DeleteController@DeletePackageQuestionUsers');