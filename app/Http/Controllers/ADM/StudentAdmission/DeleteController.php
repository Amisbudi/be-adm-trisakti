<?php

namespace app\Http\Controllers\ADM\StudentAdmission;

use App\Http\Controllers\Controller;
use App\Http\Models\ADM\StudentAdmission\Announcement_Registration_Card;
use App\Http\Models\ADM\StudentAdmission\Document;
use App\Http\Models\ADM\StudentAdmission\Document_Certificate;
use App\Http\Models\ADM\StudentAdmission\Document_Report_Card;
use App\Http\Models\ADM\StudentAdmission\Document_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Supporting;
use App\Http\Models\ADM\StudentAdmission\Document_Transcript;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year;
use Illuminate\Http\Request;
use App\Http\Models\ADM\StudentAdmission\Document_Publication;
use App\Http\Models\ADM\StudentAdmission\Exam_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_Registration_Program_Study;
use App\Http\Models\ADM\StudentAdmission\Mapping_Transcript_Participant;
use App\Http\Models\ADM\StudentAdmission\Moodle_Categories;
use App\Http\Models\ADM\StudentAdmission\Moodle_Courses;
use App\Http\Models\ADM\StudentAdmission\Moodle_Enrollments;
use App\Http\Models\ADM\StudentAdmission\Moodle_Groups;
use App\Http\Models\ADM\StudentAdmission\Moodle_Members;
use App\Http\Models\ADM\StudentAdmission\Moodle_Quizes;
use App\Http\Models\ADM\StudentAdmission\Moodle_Sections;
use App\Http\Models\ADM\StudentAdmission\Moodle_Users;
use App\Http\Models\ADM\StudentAdmission\Participant_Document;
use App\Http\Models\ADM\StudentAdmission\Participant_Education;
use App\Http\Models\ADM\StudentAdmission\Participant_Family;
use App\Http\Models\ADM\StudentAdmission\Participant_Work_Data;
use App\Http\Models\ADM\StudentAdmission\Pin_Voucher;
use App\Http\Models\ADM\StudentAdmission\Registration_History;
use App\Http\Models\ADM\StudentAdmission\Selection_Category;
use App\Http\Models\ADM\StudentAdmission\Document_Categories;
use App\Http\Models\ADM\StudentAdmission\Education_Degree;
use App\Http\Models\ADM\StudentAdmission\Selection_Categories;
use App\Http\Models\ADM\StudentAdmission\Category;
use App\Http\Models\ADM\StudentAdmission\Education_Major;
use App\Http\Models\ADM\StudentAdmission\Form;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Category;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Formulir;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Biaya;
use App\Http\Models\ADM\StudentAdmission\Master_kelas;
use App\Http\Models\ADM\StudentAdmission\Master_Matpel;
use App\Http\Models\ADM\StudentAdmission\Schedule;
use App\Http\Models\ADM\StudentAdmission\Selection_Path;
use App\Http\Models\ADM\StudentAdmission\Document_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Matapelajaran;
use App\Http\Models\ADM\StudentAdmission\Study_Program;
use App\Http\Models\ADM\StudentAdmission\Study_Program_Specialization;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class DeleteController extends Controller
{

  public function DeleteMappingStudyProgram(Request $req)
  {
    try {
      $id = Mapping_Registration_Program_Study::select('id')->where('id', '=', $req->id)->first();    //return $id->id;
      if ($id) {
        $deletedata = Mapping_Registration_Program_Study::where('id', '=', $id->id)->delete();

        return response()->json([
          'status' => 'Success',
          'Message' => 'ID ' . $id->id . ' Deleted'
        ], 200);
      }
    } catch (Exception $e) {
      DB::connection('pgsql')->rollBack();
      return response()->json([
        'status' => 'Failed',
        'Message' => 'Cant delete data',
				'error' => $e->getMessage()
      ], 500);
    }
  }

  //function for deleting participant family
  public function DeleteParticipantFamily(Request $request)
  {
    //validate id
    if ($request->id == null) {
      return response()->json([
        "status" => "Failed",
        "message" => "empty id",
      ], 403);
    }

    try {
      Participant_Family::where("id", "=", $request->id)->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Participant Family deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Participant Family failed to delete",
				'error' => $e->getMessage()
      ], 403);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete participant family. Server Problem",
      ], 500);
    }
  }

  //function for deleting participant education
  public function DeleteParticipantEducation(Request $request)
  {
    //validate id
    if ($request->id == null) {
      return response()->json([
        "status" => "Failed",
        "message" => "empty id",
      ], 403);
    }

    try {
      Participant_Education::where("id", "=", $request->id)->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Participant Education deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Participant Education failed to delete",
				'error' => $e->getMessage()
      ], 403);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete participant education. Server Problem",
      ], 500);
    }
  }

  //function for deleting participant work data
  public function DeleteParticipantWorkData(Request $request)
  {
    //validate id
    if ($request->id == null) {
      return response()->json([
        "status" => "Failed",
        "message" => "empty id",
      ], 403);
    }

    try {
      Participant_Work_Data::where("id", "=", $request->id)->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Participant Work Data deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Participant Work Data failed to delete",
				'error' => $e->getMessage()
      ], 403);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete participant work data. Server Problem",
      ], 500);
    }
  }

  //function for deleting mapping_registration_program_study
  public function DeleteMappingRegistrationProgramStudy(Request $request)
  {
    //validate id
    if ($request->registration_number == null) {
      return response()->json([
        "status" => "Failed",
        "message" => "empty registration_number",
      ], 403);
    }

    try {
      Mapping_Registration_Program_Study::where("registration_number", "=", $request->registration_number)
        ->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Mapping Registration deleted successfully",
      ], 200);
    } catch (Exception $e) {
      DB::rollBack();

      return response()->json([
        "status" => "Failed",
        "message" => "Mapping Registration failed to delete",
				'error' => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {
      DB::rollBack();

      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete mapping registration. Server Problem",
      ], 500);
    }
  }

  //function for deleting voucher
  public function DeleteVoucher(Request $request)
  {
    //validate voucher
    if ($request->voucher == null) {
      return response()->json([
        "status" => "Failed",
        "message" => "empty voucher",
      ], 500);
    }

    try {
      Pin_Voucher::where("voucher", "=", $request->voucher)->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Voucher deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Voucher failed to delete",
				'error' => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete Voucher. Server Problem",
      ], 500);
    }
  }

  public function DeleteRegistrationHistory(Request $req)
  {
    try {
      $id = Registration_History::select('id')
        ->where('registration_number', '=', $req->registration_number)
        ->where('registration_step_id', '=', $req->registration_step)
        ->first();    //return $id->id;
      if ($id) {
        $deletedata = Registration_History::where('id', '=', $id->id)->delete();
        return response()->json([
          'status' => 'Success',
          'Message' => 'ID ' . $id->id . ' Deleted'
        ], 200);
      }
    } catch (Exception $e) {
      DB::connection('pgsql')->rollBack();
      return response()->json([
        'status' => 'Failed',
        'Message' => 'Cant delete data'
      ], 500);
    }
  }

  public function DeleteMappingPathYear(Request $req)
  {
    try {
      Mapping_Path_Year::where("id", "=", $req->id)->delete();
      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Mapping path year deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Mapping path year failed to delete",
      ], 403);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete mapping path year. Server Problem",
      ], 500);
    }
  }

  //function for delete document report card
  public function DeleteDocumentReportCard(Request $req)
  {
    $data = Document_Report_Card::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete raport
      Document_Report_Card::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Report card deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Report card failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete report card. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document certificate
  public function DeleteDocumentCertificate(Request $req)
  {
    $data = Document_Certificate::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Document_Certificate::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Certificate deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Certificate failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete certificate. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document study
  public function DeleteDocumentStudy(Request $req)
  {
    $data = Document_Study::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Document_Study::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document study deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document study failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document study. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document study
  public function DeleteDocumentProposal(Request $req)
  {
    $data = Document_Study::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Document_Study::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document proposal deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document proposal failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document proposal. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document participant
  public function DeleteParticipantDocument(Request $req)
  {
    $data = Participant_Document::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Participant_Document::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document participant deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document participant failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document participant. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document supporting
  public function DeleteDocumenSupporting(Request $req)
  {
    $data = Document_Supporting::find($req->id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Document_Supporting::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document supporting deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document supporting failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document supporting. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete announcement registration card
  public function DeleteAnnouncementRegistrationCard(Request $req)
  {
    try {
      Announcement_Registration_Card::find($req->id)->delete();

      DB::commit();
      return response()->json([
        "status" => "Success",
        "message" => "Announcement deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Announcement failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete announcement. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  public function DeleteParticipantGrade(Request $req)
  {
    try {
      $data = Participant_Grade::select('*')
        ->where('registration_number', '=', $req->registration_number)
        ->first();

      Participant_Grade::find($data->id)->delete();

      DB::commit();
      return response()->json([
        "status" => "Success",
        "message" => "Deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //api for delete moodle categories
  public function DeleteMoodleCategory(Request $req)
  {
    //get selection path
    $moodle_category = Moodle_Categories::select('*')->where('selection_path_id', '=', $req->selection_path_id)->first();

    //validate selection path
    if ($moodle_category == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Kategori tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_categories';

      //categories must be array, because moodle required array
      $formParam['categories'][0]['idnumber'] = $moodle_category->selection_path_id;
      $formParam['categories'][0]['recursive'] = 1;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //delete moodle from database
      Moodle_Categories::find($moodle_category->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Jalur seleksi dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus kategori jalur seleksi moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle course
  public function DeleteMoodleCourse(Request $req)
  {
    //get selection path
    $moodle_category = Moodle_Courses::select('id')->where('id', '=', $req->moodle_course_id)->first();

    //validate selection path
    if ($moodle_category == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_courses';

      //course must be array, because moodle required array
      $formParam['courses'][0]['idnumber'] = $moodle_category->id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Courses::find($moodle_category->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle user
  public function DeleteMoodleUser(Request $req)
  {
    //get selection path
    $moodle_user = Moodle_Users::select('id')->where('id', '=', $req->moodle_user_id)->first();

    //validate selection path
    if ($moodle_user == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_users';

      //course must be array, because moodle required array
      $formParam['users'][0]['idnumber'] = $moodle_user->id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Users::find($moodle_user->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle section
  public function DeleteMoodleSection(Request $req)
  {
    //get selection path
    $moodle_section = Moodle_Sections::select('id')->where('id', '=', $req->moodle_section_id)->first();

    //validate selection path
    if ($moodle_section == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_sections';

      //course must be array, because moodle required array
      $formParam['sections'][0]['id'] = $moodle_section->id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Sections::find($moodle_section->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle group
  public function DeleteMoodleGroup(Request $req)
  {
    //get selection path
    $moodle_group = Moodle_Groups::select('id')->where('id', '=', $req->moodle_group_id)->first();

    //validate selection path
    if ($moodle_group == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_groups';

      //course must be array, because moodle required array
      $formParam['groups'][0]['idnumber'] = $moodle_group->id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Groups::find($moodle_group->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle member
  public function DeleteMoodleMember(Request $req)
  {
    //get selection path
    $moodle_member = Moodle_Members::select('*')->where('id', '=', $req->moodle_member_id)->first();

    //validate selection path
    if ($moodle_member == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_group_members';

      //course must be array, because moodle required array
      $formParam['members'][0]['groupid'] = $moodle_member->moodle_group_id;
      $formParam['members'][0]['userid'] = $moodle_member->moodle_user_id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Members::find($moodle_member->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle enrollment
  public function DeleteMoodleEnrollment(Request $req)
  {
    //get selection path
    $moodle_enrollment = Moodle_Enrollments::select('*')->where('id', '=', $req->moodle_enrollment_id)->first();

    //validate selection path
    if ($moodle_enrollment == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_unenrol_users';

      //course must be array, because moodle required array
      $formParam['enrolments'][0]['userid'] = $moodle_enrollment->moodle_user_id;
      $formParam['enrolments'][0]['courseid'] = $moodle_enrollment->moodle_course_id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Enrollments::find($moodle_enrollment->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete moodle enrollment
  public function DeleteMoodleQuiz(Request $req)
  {
    //get selection path
    $moodle_quiz = Moodle_Quizes::select('*')->where('id', '=', $req->moodle_quiz_id)->first();

    //validate selection path
    if ($moodle_quiz == null) {
      return response([
        'status' => 'Failed',
        'message' => 'Data tidak terdaftar di dalam database'
      ], 500);
    }

    try {
      //initialize moodle
      $http = new Client();
      $url = env('CBT_MOODLE_URL');

      $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
      $formParam['moodlewsrestformat'] = 'json';
      $formParam['wsfunction'] = 'local_trisakti_api_delete_quizes';

      //course must be array, because moodle required array
      $formParam['quizes'][0]['id'] = $moodle_quiz->id;

      //execute moodle
      $request = $http->post($url, ['form_params' => $formParam]);
      $response = json_decode($request->getBody(), true);

      //validate response
      if ($response['data'][0]['status'] == false) {
        return response([
          'status' => 'Failed',
          'message' => 'Data gagal dihapus ' . $response['data'][0]['exception'],
          'response' => $response
        ], 500);
      }

      //delete moodle from database
      Moodle_Quizes::find($moodle_quiz->id)->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data dihapus dari moodle',
        'response' => $response
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus data moodle',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  //api for delete document transcript
  public function DeleteDocumentTranscript(Request $req)
  {
    $document_transcript = Document_Transcript::select('*')
      ->where('id', '=', $req->document_transcript_id)
      ->first();

    try {
      //get id document
      $doc_id = $document_transcript->document_id;

      //delete mapping transcript item
      Mapping_Transcript_Participant::where('document_transcript_id', '=', $req->document_transcript_id)->delete();

      //delete document transcript
      Document_Transcript::find($req->document_transcript_id)->delete();

      //delete document
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document deleted successfully",
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  //function for delete document publication
  public function DeleteDocumenPublication(Request $req)
  {
    $data = Document_Publication::find($req->document_publication_id);

    try {
      //get id document
      $doc_id = $data->document_id;

      //delete doucument first before delete relation of document
      Document_Publication::find($data->id)->delete();
      Document::find($doc_id)->delete();

      DB::commit();

      return response()->json([
        "status" => "Success",
        "message" => "Document publication deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document publication failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document publication. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  public function DeleteMappingNewStudentDocumentType(Request $req)
  {
    try {
      Mapping_New_Student_Document_Type::find($req->id)->delete();

      DB::commit();
      return response()->json([
        "status" => "Success",
        "message" => "Document publication deleted successfully",
      ], 200);
    } catch (Exception $e) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Document publication failed to delete",
        "error" => $e->getMessage()
      ], 500);
    } catch (QueryException $qe) {

      DB::rollBack();
      return response()->json([
        "status" => "Failed",
        "message" => "Failed to delete document publication. Server Problem",
        "error" => $qe->getMessage()
      ], 500);
    }
  }

  public function DeleteExamType(Request $req)
  {
    try {
      $examType = Exam_Type::findOrFail($req->id);
      $examType->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Exam Type has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus kategori ujian',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  
  public function DeleteCategory(Request $req)
  {
    try {
      $category = Category::findOrFail($req->id);
      $category->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data kategori ujian telah dihapus',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus kategori ujian',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteForms(Request $req)
  {
    try {
      $form = Form::where('id', $req->id)->first();
      $form->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data formulir telah dihapus',
      ], 200);
    } catch (Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus formulir ujian',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteSchedule(Request $req)
  {
    try {
      $schedule = Schedule::findOrFail($req->id);
      $schedule->delete();

      return response([
        'status' => 'Success',
        'message' => 'Data jadwal ujian telah dihapus',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus jadwal ujian ujian',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteDocumentCategories(Request $req)
  {
    try {
      $documentCategory = Document_Categories::findOrFail($req->id);
      $documentCategory->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Document category has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the document category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteSelectionCategories(Request $req)
  {
    try {
      $documentCategory = Selection_Categories::findOrFail($req->id);
      $documentCategory->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Document category has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the document category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteStudentInterest(Request $req)
  {
    try {
      $documentCategory = Education_Major::findOrFail($req->id);
      $documentCategory->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Document category has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the document category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteEducationDegree(Request $req)
  {
    try {
      $educationDegree = Education_Degree::findOrFail($req->id);
      $educationDegree->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Education Degree has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the education degree',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteStudyProgram(Request $req)
  {
    try {
      $studyProgram = Study_Program::findOrFail($req->id);
      $studyProgram->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Education Degree has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the education degree',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteMappingProdiCategory(Request $req)
  {
    try {
      $mappingProdiCategory = Mapping_Prodi_Category::findOrFail($req->id);
      $mappingProdiCategory->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Mapping Prodi Category has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Mapping Prodi Category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteSelectionCategory(Request $req)
  {
    try {
      $selectionCategory = Selection_Category::findOrFail($req->id);
      $selectionCategory->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Selection Category has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Selection Category',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  
  public function DeleteMappingProdiFormulir(Request $req)
  {
    try {
      $mappingProdiFormulir = Mapping_Prodi_Formulir::findOrFail($req->id);
      $mappingProdiFormulir->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Mapping Prodi Formulir has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Selection Category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteMappingProdiBiaya(Request $req)
  {
    try {
      $mappingProdiBiaya = Mapping_Prodi_Biaya::findOrFail($req->id);
      $mappingProdiBiaya->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Mapping Prodi Biaya has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Selection Category',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteMasterMataPelajaran(Request $req)
  {
    try {
      $masterMataPelajaran = Master_Matpel::findOrFail($req->id);
      $masterMataPelajaran->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Mata Pelajaran has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Mata Pelajaran',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteStudyProgramSpecialization(Request $req)
  {
    try {
      $masterKelas = Study_Program_Specialization::findOrFail($req->id);
      $masterKelas->delete();

      return response()->json([
        'status' => 'Success',
        'message' => 'Class has been deleted successfully',
      ], 200);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'Failed',
        'message' => 'Failed to delete the Class',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteFaculty(Request $req)
  {
    try {
      $study_program = Study_Program::where('classification_id', $req->classification_id)->first();
      $study_program->delete();

      return response([
        'status' => 'Success',
        'message' => 'Study program telah dihapus',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus jadwal study program',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteDocumentType(Request $req)
  {
    try {
      $study_program = Document_Type::where('id', $req->id)->first();
      $study_program->delete();

      return response([
        'status' => 'Success',
        'message' => 'Dokumen telah dihapus',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus dokumen',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function DeleteMappingProdiMatapelajaran(Request $req)
  {
    try {
      $mapping_prodi_matapellajaran = Mapping_Prodi_Matapelajaran::where('id', $req->id)->first();
      $mapping_prodi_matapellajaran->delete();

      return response([
        'status' => 'Success',
        'message' => 'Mapping Prodi Mata Pelajaran telah dihapus',
      ], 200);
    } catch (\Exception $e) {
      return response([
        'status' => 'Failed',
        'message' => 'Gagal menghapus Mapping Prodi Mata Pelajaran',
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
