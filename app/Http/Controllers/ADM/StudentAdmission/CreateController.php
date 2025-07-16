<?php

namespace app\Http\Controllers\ADM\StudentAdmission;

use App\Http\Controllers\ADM\StudentAdmission\BniEnc;
use App\Http\Controllers\Controller;
use App\Http\Models\ADM\StudentAdmission\Announcement_Registration_Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use URL;
use Excel;

use App\Http\Models\ADM\StudentAdmission\Framework_Mapping_User_Role;
use App\Http\Models\ADM\StudentAdmission\Framework_User;
use App\Http\Models\ADM\StudentAdmission\Participant;
use App\Http\Models\ADM\StudentAdmission\Selection_Programs;
use App\Http\Models\ADM\StudentAdmission\Location_Exam;
use App\Http\Models\ADM\StudentAdmission\Selection_Path;
use App\Http\Models\ADM\StudentAdmission\Path_Exam_Detail;
use App\Http\Models\ADM\StudentAdmission\Mapping_Location_Selection;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Step;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Document;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Price;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Study_Program;
use App\Http\Models\ADM\StudentAdmission\Question;
use App\Http\Models\ADM\StudentAdmission\Question_Answer;
use App\Http\Models\ADM\StudentAdmission\Questionare;
use App\Http\Models\ADM\StudentAdmission\Answer_Option;
use App\Http\Models\ADM\StudentAdmission\Registration;
use App\Http\Models\ADM\StudentAdmission\Participant_Education;
use App\Http\Models\ADM\StudentAdmission\Participant_Family;
use App\Http\Models\ADM\StudentAdmission\Participant_Work_Data;
use App\Http\Models\ADM\StudentAdmission\Participant_Document;
use App\Http\Models\ADM\StudentAdmission\Mapping_Registration_Program_Study;
use App\Http\Models\ADM\StudentAdmission\Registration_History;
use App\Http\Models\ADM\StudentAdmission\Document;
use App\Http\Models\ADM\StudentAdmission\Document_Report_Card;
use App\Http\Models\ADM\StudentAdmission\Document_Certificate;
use App\Http\Models\ADM\StudentAdmission\Document_Recomendation;
use App\Http\Models\ADM\StudentAdmission\Document_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Supporting;
use App\Http\Models\ADM\StudentAdmission\Document_Transcript;
use App\Http\Models\ADM\StudentAdmission\Document_Utbk;
use App\Http\Models\ADM\StudentAdmission\ExcelModel\ParticipantBulk;
use App\Http\Models\ADM\StudentAdmission\ExcelModel\RegistrationResultBulk;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year_Intake;
use App\Http\Models\ADM\StudentAdmission\Mapping_Report_Subject_Path;
use App\Http\Models\ADM\StudentAdmission\Mapping_Transcript_Participant;
use App\Http\Models\ADM\StudentAdmission\Mapping_Utbk_Path;
use App\Http\Models\ADM\StudentAdmission\Moodle_Categories;
use App\Http\Models\ADM\StudentAdmission\Moodle_Courses;
use App\Http\Models\ADM\StudentAdmission\Moodle_Enrollments;
use App\Http\Models\ADM\StudentAdmission\Moodle_Groups;
use App\Http\Models\ADM\StudentAdmission\Moodle_Members;
use App\Http\Models\ADM\StudentAdmission\Moodle_Quizes;
use App\Http\Models\ADM\StudentAdmission\Moodle_Sections;
use App\Http\Models\ADM\StudentAdmission\Participant_Grade;
use App\Http\Models\ADM\StudentAdmission\Passing_Grade;
use App\Http\Models\ADM\StudentAdmission\PasswordReset;
use App\Http\Models\ADM\StudentAdmission\Pin_Voucher;
use App\Http\Models\ADM\StudentAdmission\Registration_Result;
use App\Http\Models\ADM\StudentAdmission\Registration_Result_Sync;
use App\Http\Models\ADM\StudentAdmission\Transaction_Request;
use App\Http\Models\ADM\StudentAdmission\Transaction_Voucher;
use App\Http\Models\ADM\StudentAdmission\Document_Publication;
use App\Http\Models\ADM\StudentAdmission\Exam_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_New_Student_Step;
use App\Http\Models\ADM\StudentAdmission\New_Student;
use App\Http\Models\ADM\StudentAdmission\Selection_Category;
use App\Http\Models\ADM\StudentAdmission\Transaction_Billing;
use App\Http\Models\ADM\StudentAdmission\Document_Categories;
use App\Http\Models\ADM\StudentAdmission\Education_Degree;
use App\Http\Models\ADM\StudentAdmission\Category;
use App\Http\Models\ADM\StudentAdmission\Document_Type;
use App\Http\Models\ADM\StudentAdmission\Education_Major;
use App\Http\Models\ADM\StudentAdmission\Form;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Category;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Formulir;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Biaya;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Matapelajaran;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Minat;
use App\Http\Models\ADM\StudentAdmission\Master_Matpel;
use App\Http\Models\ADM\StudentAdmission\Schedule;
use App\Http\Models\ADM\StudentAdmission\Study_Program;
use App\Http\Models\ADM\StudentAdmission\Study_Program_Specialization;
use App\Http\Models\ADM\StudentAdmission\CBT_Package_Questions;
use App\Http\Models\ADM\StudentAdmission\CBT_Package_Question_Users;
use App\Http\Models\ADM\StudentAdmission\Change_Program;
use App\Http\Models\ADM\StudentAdmission\Diskon_Khusus;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Ujian;
use App\Http\Models\ADM\StudentAdmission\Master_Package;
use App\Http\Models\ADM\StudentAdmission\Master_Package_Angsuran;
use App\Http\Models\ADM\StudentAdmission\New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\Refund_Request;
use App\Http\Models\ADM\StudentAdmission\Transfer_Credit;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class CreateController extends Controller
{
	public function InserttoFrameworkUsers(Request $req)
	{
		//validate duplicate username
		$validate = Participant::where(DB::raw("lower(username)"), '=', strtolower($req->email))->first();
		if ($validate != null) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, pendaftaran tidak berhasil, Email sudah pernah digunakan. Silahkan login ulang'
			], 200);
		}

		try {
			//validate phone number duplicate
			$validate = Validator::make($req->all(), [
				'mobile_phone_number' => 'unique:participants'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, pendaftaran tidak berhasil. Nomor ponsel sudah digunakan.'
				], 200);
			}

			$CreateUser = Participant::create([
				'username' => strtolower($req->email),
				'password' => Hash::make($req->password),
				'fullname' => $req->name,
				'created_by' => 'admisi-' . strtolower($req->email),
				'mobile_phone_number' => $req->mobile_phone_number,
				'isverification' => '0',
			]);

			if ($CreateUser) {
				$this->SendConfirmationEmail($req->email, $req->password, $req->name);
			}

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Pendaftaran Berhasil. Kami telah mengirimkan pesan ke email Anda.'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, pendaftaran tidak berhasil. Silahkan coba lagi',
				'error' => $e->getMessage()
			], 200);
		}
	}

	public function SendConfirmationEmail($email, $password, $name)
	{
		//get uid
		$uid = Participant::select('id')
			->where('username', '=', strtolower($email))
			->where('created_by', '=', ('admisi-' . strtolower($email)))
			->first();

		//get tmp link
		$link = URL::temporarySignedRoute(
			'af3ac15a0392e10afbf3feb197ffed24',
			now()->addHour(60),
			['id' => $uid],
			false
		);

		$data = [
			'email' => $email,
			'password' => $password,
			'link_verification' => env('LINK_VERIFY') . str_replace('/api', '', $link),
		];

		try {
			Mail::send('register_mail', $data, function ($message) use ($email, $password, $name) {
				$message->to($email, $name)->subject('Trisakti University Admission');
			});
		} catch (\Throwable $th) {
			return response()->json([
				'message' => $th->getMessage()
			], 500);
		}
	}

	public function SendSuccessResetPasswordEmail($email, $password, $name)
	{
		$data = [
			'email' => strtolower($email),
			'password' => $password
		];

		Mail::send('success_reset_password_mail', $data, function ($message) use ($email, $password, $name) {
			$message->to($email, $name)->subject('Trisakti University Admission');
		});
	}

	public function Verifymail($id)
	{
		try {
			//update verification participant
			Participant::find($id)->update([
				'email_verified_at' => Carbon::now(),
				'isverification' => true
			]);

			//create or update user in framework
			$participant = Participant::select('username', 'password')->where('id', '=', $id)->first();

			$f_user = Framework_User::select('*')->where('username', '=', $participant->username)->first();

			if ($f_user == null) {
				//create framework user
				$data = Framework_User::create([
					'username' => $participant->username,
					'password' => $participant->password,
					'created_by' => $participant->username,
					'updated_by' => $participant->username
				]);

				Framework_Mapping_User_Role::create([
					'user_id' => $data->id,
					'oauth_role_id' => env('OAUTH_ID', '289'),
					'created_by' => 'admisi-' . $participant->username,
					'updated_by' => 'admisi-' . $participant->username
				]);
			} else {
				//create framework user
				Framework_User::where('id', '=', $f_user->id)->update([
					'username' => $participant->username,
					'password' => $participant->password,
					'created_by' => $participant->username,
					'updated_by' => $participant->username
				]);
			}

			return response([
				'status' => 'Success',
				'link' => env('RETURN_VERIFY'),
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'link' => null,
				'error' => $e->getMessage()
			], 200);
		}
	}

	public function ForgotPassword(Request $req)
	{
		$participant = Participant::where(DB::raw("lower(username)"), '=', strtolower($req->email))->first();

		//validate email
		if ($participant != null) {
			//insert to password reset
			$createReset = PasswordReset::create([
				'username' => $participant->username,
				'token' => Str::random(32),
				'participant_id' => $participant->id
			]);

			$email['username'] = $participant->username;
			$email['name'] = $participant->fullname;

			$link = URL::temporarySignedRoute('4e374a7443c209ffcdcb722eb1b0e989', now()->addHour(60), [
				'id' => $createReset->id,
				'token' => $createReset->token
			], false);

			$data = [
				'name' => $email['name'],
				'link_verification' => env('LINK_VERIFY') . str_replace('/api', '', $link)
			];

			$participantName = $email['name'];
			$participantEmail = $email['username'];

			try {
				Mail::send('reset_password_mail', $data, function ($message) use ($participantName, $participantEmail) {
					$message->to($participantEmail, $participantName)->subject('Trisakti University Admission');
				});

				return response([
					'status' => 'Success',
					'message' => 'Reset Password Sent to ' . $email['username'],
					'url' => env('LINK_VERIFY') . str_replace('/api', '', $link)
				], 200);
			} catch (\Exception $e) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, email tidak terdaftar didalam sistem.',
					'error' => $e->getMessage()
				], 200);
			}
		} else {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, email tidak terdaftar didalam sistem.'
			], 500);
		}
	}

	public function ReturnPageResetPassword($id, $token)
	{
		$validate = PasswordReset::where('id', '=', $id)->where('token', '=', $token)->first();

		if ($validate != null) {
			return response([
				'status' => 'Success',
				'link' => (env('URL_RESET_PASSWORD') . $id . '/' . $token),
			], 200);
		} else {
			return response([
				'status' => 'Failed',
				'message' => 'Page Not Found',
			], 500);
		}
	}

	public function ResetPassword($id, $token, Request $req)
	{
		$validate = PasswordReset::where('id', '=', $id)->where('token', '=', $token)->first();

		if ($validate != null) {
			//get participant data
			$participant = Participant::select('id', 'fullname', 'username', 'isverification')
				->where('username', '=', $validate->username)
				->first();

			//harus di berhentikan dulu, karena participant dapat link melalui email
			if ($req->password == null) {
				return response($participant, 200);
			}

			try {
				Participant::find($participant->id)->update([
					'password' => Hash::make($req->password)
				]);

				Framework_User::where('username', '=', $participant->username)
					->update([
						'password' => Hash::make($req->password)
					]);

				DB::connection('pgsql')->commit();
				DB::connection('framework')->commit();

				if ($participant->isverification != true) {
					$this->SendConfirmationEmail($participant->username, $req->password, $participant->fullname);

					return response([
						'status' => 'Success',
						'message' => 'Berhasil memperbaruhi password. Silahkan verifikasi email anda'
					], 200);
				} else {
					$this->SendSuccessResetPasswordEmail($participant->username, $req->password, $participant->fullname);
					return response([
						'status' => 'Success',
						'message' => 'Berhasil memperbaruhi password. Silahkan login kembali'
					], 200);
				}
			} catch (\Exception $e) {
				DB::connection('pgsql')->rollBack();
				return $e;
				return response([
					'status' => 'Failed',
					'message' => 'Gagal memperbaruhi password.'
				], 500);
			}
		} else {
			return response([
				'status' => 'Failed',
				'message' => 'Link kadaluarsa. Silahkan request link baru.'
			], 500);
		}
	}

	public function InsertSelectionProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$Create = Selection_Programs::create([
				'name' => $req->name,
				'description' => $req->description,
				'active_status' => $req->active_status,
				'created_by' => $by,
				'category' => $req->category
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Program Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertLocationExam(Request $req)
	{
		try {
			$by = $req->header("X-I");
			Location_Exam::create([
				'city' => $req->city,
				'location' => $req->location,
				'address' => $req->address,
				'active_status' => $req->active_status,
				'created_by' => $by,
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Lokasi Ujian Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertSelectionPath(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Selection_Path::create([
				'name' => $req->name,
				'active_status' => $req->active_status,
				'exam_status' => $req->exam_status,
				'english_name' => $req->english_name,
				'maks_program' => $req->maks_program,
				'created_by' => $by
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
				'selection_path_id' => $create->id
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoMappingLocationSelection(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create_exam_location = Mapping_Location_Selection::create([
				'selection_path_id' => $req->selection_path_id,
				'location_exam_id' => $req->location_exam_id,
				'active_status' => $req->active_status,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoExamDetail(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$path_exam_detail = Path_Exam_Detail::create([
				'selection_path_id' => $req->selection_path_id,
				'exam_start_date' => $req->start_date,
				'exam_end_date' => $req->end_date,
				'active_status' => $req->active_status,
				'created_by' => $by,
				'exam_location_id' => $req->exam_location_id,
				'quota' => $req->quota,
				'session_one_start' => $req->session_one_start,
				'session_two_start' => $req->session_two_start,
				'session_three_start' => $req->session_three_start,
				'session_one_end' => $req->session_one_end,
				'session_two_end' => $req->session_two_end,
				'session_three_end' => $req->session_three_end,
				'exam_type_id' => $req->exam_type_id,
				'location' => $req->location,
				'class_type' => $req->class_type
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
				'id' => $path_exam_detail->id
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoMappingPathStep(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Mapping_Path_Step::create([
				'selection_path_id' => $req->selection_path_id,
				'registration_step_id' => $req->registration_step_id,
				'ordering' => $req->ordering,
				'active_status' => $req->active_status,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoMappingPathDocument(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Mapping_Path_Document::create([
				'selection_path_id' => $req->selection_path_id,
				'document_type_id' => $req->document_type_id,
				'active_status' => $req->active_status,
				'created_by' => $by,
				'program_study_id' => $req->program_study_id,
				'required' => $req->required,
				'is_value' => $req->is_value
			]);
			$this->updateMappingNewStudentDocumentType($req->selection_path_id, $req->program_study_id, $req->document_type_id);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoMappingPathPrice(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$create = Mapping_Path_Price::create([
				'selection_path_id' => $req->selection_path_id,
				'price' => $req->price,
				'maks_study_program' => $req->maks_study_program,
				'active_status' => $req->active_status,
				'created_by' => $by,
				'mapping_path_year_id' => $req->mapping_path_year_id,
				'study_program_id' => $req->study_program_id,
				'form_id' => $req->form_id,
				'category' => $req->category,
				'is_medical' => $req->is_medical
			]);
			DB::connection('pgsql')->commit();
			return response([
				'id' => $create->id,
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoMappingPathStudyProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Mapping_Path_Study_Program::create([
				'selection_path_id' => $req->selection_path_id,
				'program_study_id' => $req->program_study_id,
				'minimum_donation' => $req->minimum_donation,
				'active_status' => $req->active_status,
				'quota' => $req->quota,
				'created_by' => $by,
				'is_technic' => $req->is_technic
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoQuestions(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Question::create([
				'questionare_id' => $req->questionare_id,
				'question_type_id' => $req->question_type_id,
				'detail' => $req->detail,
				'active_status' => $req->active_status,
				'created_by' => $by,
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoQuestionare(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Questionare::create([
				'name' => $req->name,
				'description' => $req->description,
				'selection_path_id' => $req->selection_path_id,
				'active_status' => $req->active_status,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoAnswerOption(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Answer_Option::create([
				'question_id' => $req->question_id,
				'value' => $req->value,
				'ordering' => $req->ordering,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoQuestionAnswer(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Question_Answer::create([
				'question_id' => $req->question_id,
				'answer_list' => $req->answer_list,
				'participant_id' => $req->participant_id,
				'notes' => $req->notes,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertBulkQuestionAnswer(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$datas = json_decode($req->json, true);
			// $path = $req->file('json_file')->getRealPath();
			// $datas = json_decode(file_get_contents($path), true);

			$answers = array();
			foreach ($datas as $key => $value) {

				$answer_list = array();

				if ($value['answer_list'] != null) {
					foreach ($value['answer_list'] as $key => $val) {
						array_push($answer_list, $val['id']);
					}
				}

				array_push($answers, [
					'question_id' => $value['question_id'],
					'answer_list' => ($value['answer_list'] == null) ? null : '{' . implode(',', $answer_list) . '}',
					'participant_id' => $req->participant_id,
					'notes' => $value['notes'],
					'created_by' => $by,
					'updated_by' => $by,
					'created_at' => Carbon::now(),
					'updated_at' => Carbon::now()
				]);
			}

			// return $answers;
			Question_Answer::insert($answers);

			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (Throwable $th) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	public function insertIntoRegistration(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$data = Registration::select('registration_number')
				->where('selection_path_id', '=', $req->selection_path_id)
				->count();

			$mpyi = Mapping_Path_Year_Intake::select('school_year')->where('id', '=', $req->mapping_path_year_intake_id)->first();

			$number = (int) $data + 3;
			$max = str_pad($number, 5, '0', STR_PAD_LEFT);
			$year = substr($mpyi->school_year, 0, 2);
			$now = Carbon::now()->format('m');
			$registration_number = $year . $now . '' . $req->selection_path_id . '' . $max;

			while (true) {
				$check = Registration::select('registration_number')
					->where('registration_number', '=', $registration_number)
					->first();

				if ($check != null) {
					$registration_number = $registration_number + 1;
				} else {
					break;
				}
			}

			//return $registration_number;
			Registration::create([
				'registration_number' => $registration_number,
				'participant_id' => $req->participant_id,
				'selection_path_id' => $req->selection_path_id,
				'activation_pin' => false,
				'created_by' => $by,
				'mapping_path_year_id' => $req->mapping_path_year_id,
				'mapping_path_year_intake_id' => $req->mapping_path_year_intake_id
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
				'registration_number' => $registration_number
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoParticipantEducation(Request $req)
	{
			$by = $req->header("X-I");
			if ($req->education_major_id) {
				$education_major_id = $req->education_major_id;
			} else {
				$data = Education_Major::create([
					'major' => $req->education_major,
					'education_degree_id' => $req->education_degree_id,
					'is_technic' => 0,
					'created_by' => $by,
					'updated_by' => $by,
					// 'created_at' => $req->created_at,
					// 'updated_at' => $req->updated_at,

				]);
				$education_major_id = $data->id;
				$minats = Education_Major::whereIn('education_degree_id', [8, 9, 10, 11])->pluck('id');
				$prodi = Mapping_Prodi_Minat::whereIn('minat_id', $minats)->get();

				foreach ($prodi as $key => $item) {
					Mapping_Prodi_Minat::create([
						'fakultas' => $item->fakultas,
						'fakultas_id' => $item->faculty_id,
						'prodi_id' => $item->prodi_id,
						'nama_prodi' => $item->nama_prodi,
						'nama_minat' => $data->major,
						'minat_id' => $data->id,
						'quota' => 0,
						'status' => true
					]);
				}
			}

		try {

			$create = Participant_Education::create([
				'participant_id' => $req->participant_id,
				'education_degree_id' => $req->education_degree_id,
				'education_major_id' => $education_major_id,
				'school_id' => $req->school_id,
				'education_major' => $req->education_major,
				'school' => $req->school,
				'graduate_year' => $req->graduate_year,
				'student_id' => $req->student_id,
				'last_score' => $req->last_score,
				'created_by' => $by,
				'student_foreign' => $req->student_foreign,
				'city_id' => $req->city_id,
				'npsn' => $req->npsn,
				'npsn_he' => $req->npsn_he
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'exception' => $e,
				'exception_message' => $e->getMessage()
			], 500);
		}
	}

	public function insertIntoParticipantFamily(Request $req)
	{
		try {
			$by = $req->header("X-I");
			if ($req->family_relationship_id == 1) {
				$gender = '1';
			} elseif ($req->family_relationship_id == 2) {
				$gender = '2';
			} else {
				$gender = $req->gender;
			}

			Participant_Family::create([
				'participant_id' => $req->participant_id,
				'family_relationship_id' => $req->family_relationship_id,
				'family_name' => $req->family_name,
				'email' => $req->email,
				'mobile_phone_number' => $req->mobile_phone_number,
				'birth_place' => strtoupper($req->birth_place),
				'birth_date' => $req->birth_date,
				'gender' => $gender,
				'education_degree_id' => $req->education_degree_id,
				'work_status' => $req->work_status,
				'work_position' => $req->work_position,
				'work_income_range_id' => $req->work_income_range_id,
				'address_country' => $req->address_country,
				'address_province' => $req->address_province,
				'address_city' => $req->address_city,
				'address_disctrict' => $req->address_disctrict,
				'address_detail' => $req->address_detail,
				'address_postal_code' => $req->address_postal_code,
				'created_by' => $by,
				'work_field_id' => $req->work_field_id,
				'work_type_id' => $req->work_type_id,
				'company_name' => $req->company_name,
				'identify_number' => $req->identify_number
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function insertIntoParticipantWorkData(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Participant_Work_Data::create([
				'participant_id' => $req->participant_id,
				'work_field_id' => $req->work_field_id,
				'company_name' => $req->company_name,
				'work_position' => $req->work_position,
				'work_start_date' => $req->work_start_date,
				'work_end_date' => $req->work_end_date,
				'company_address' => $req->company_address,
				'company_phone_number' => $req->company_phone_number,
				'created_by' => $by,
				'work_type_id' => $req->work_type_id,
				'work_income_range_id' => $req->work_income_range_id
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertIntoParticipantDocument(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by,
				'approval_final_status' => $req->approval_final_status,
				'approval_final_date' => isset($req->approval_final_status) ? Carbon::now() : null,
				'approval_final_by' => isset($req->approval_final_status) ? $by : null,
				'approval_final_comment' => $req->approval_final_comment
			]);
			$create = Participant_Document::Create(
				[
					'participant_id' => $req->participant_id,
					'document_id' => $document->id,
					'created_by' => $by,
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'document_id' => $document->id,
				'participant_document_id' => $create->id,
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertIntoMappingStudyProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Mapping_Registration_Program_Study::create([
				'registration_number' => $req->registration_number,
				'mapping_path_study_program_id' => $req->mapping_path_study_program_id,
				'priority' => $req->priority,
				'education_fund' => $req->education_fund,
				'created_by' => $by,
				'program_study_id' => $req->program_study_id,
				'study_program_specialization_id' => $req->study_program_specialization_id
			]);
			DB::connection('pgsql')->commit();
			return response([
				'id' => $create->id,
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertIntoRegistrationHistory(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$create = Registration_History::create([
				'registration_number' => $req->registration_number,
				'registration_step_id' => $req->registration_step_id,
				'created_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertIntoDocumentReportCard(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$document = Document::create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'created_by' => $by,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'approval_final_status' => $req->approval_final_status,
				'approval_final_date' => isset($req->approval_final_status) ? Carbon::now() : null,
				'approval_final_by' => isset($req->approval_final_status) ? $by : null,
				'approval_final_comment' => $req->approval_final_comment
			]);

			$card = Document_Report_Card::create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'semester_id' => $req->semester_id,
					'range_score' => $req->range_score,
					'mapel1' => $req->mapel1,
					'mapel2' => $req->mapel2,
					'mapel3' => $req->mapel3,
					'mapel4' => $req->mapel4,
					'mapel5' => $req->mapel5,
					'mapel6' => $req->mapel6,
					'mapel7' => $req->mapel7,
					'mapel8' => $req->mapel8,
					'mapel9' => $req->mapel9,
					'mapel10' => $req->mapel10,
					'mapel11' => $req->mapel11,
					'mapel12' => $req->mapel12,
					'alias1' => $req->alias1,
					'alias2' => $req->alias2,
					'alias3' => $req->alias3,
					'alias4' => $req->alias4,
					'alias5' => $req->alias5,
					'alias6' => $req->alias6,
					'alias7' => $req->alias7,
					'alias8' => $req->alias8,
					'alias9' => $req->alias9,
					'alias10' => $req->alias10,
					'alias11' => $req->alias11,
					'alias12' => $req->alias12,
					'registration_number' => $req->registration_number,
					'gpa' => $req->gpa
				]
			);

			return response([
				'status' => 'Success',
				'report_id' => $card->id,
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	public function InsertIntoDocumentCertificate(Request $req)
	{
		try {
			//validate size file if size > 2 mb break program
			$validate = Validator::make($req->all(), [
				'url' => 'file|max:2100'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, ukuran file harus lebih kecil dari 2 Mb'
				], 500);
			}

			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by
			]);
			$create = Document_Certificate::Create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'certificate_type_id' => $req->certificate_type_id,
					'certificate_level_id' => $req->certificate_level_id,
					'publication_year' => $req->publication_year,
					'certificate_score' => $req->certificate_score,
					'registration_number' => $req->registration_number
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'document_certificate_id' => $create->id,
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertIntoDocumentSupporting(Request $req)
	{
		try {
			//validate size file if size > 2 mb break program
			$validate = Validator::make($req->all(), [
				'url' => 'file|max:2100'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, ukuran file harus lebih kecil dari 2 Mb'
				], 500);
			}

			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by
			]);
			$create = Document_Supporting::Create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'pic_name' => $req->pic_name,
					'pic_phone_number' => $req->pic_phone_number,
					'pic_email_address' => $req->pic_email_address,
					'pic_address' => $req->pic_address,
					'registration_number' => $req->registration_number
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function InsertIntoDocumentStudy(Request $req)
	{
		try {
			//validate size file if size > 2 mb break program
			$validate = Validator::make($req->all(), [
				'url' => 'file|max:2100'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, ukuran file harus lebih kecil dari 2 Mb'
				], 500);
			}

			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by
			]);
			$create = Document_Study::Create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'updated_by' => $by,
					'score' => $req->score,
					'registration_number' => $req->registration_number,
					'year' => $req->year
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertIntoDocumentProposal(Request $req)
	{
		try {
			//validate size file if size > 5 mb break program
			$validate = Validator::make($req->all(), [
				'url' => 'file|max:5100'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, ukuran file harus lebih kecil dari 5 Mb'
				], 500);
			}

			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by
			]);
			$create = Document_Study::Create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'updated_by' => $by,
					'registration_number' => $req->registration_number,
					'title' => $req->title
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api ini berfungsi untuk menyimpan prodi pilihan dari
	public function CreateOrUpdateRegistrationResultProgramStudy(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$registration = Registration::select()
				->where('registrations.registration_number', '=', $req->registration_number)
				->first();

			Registration_Result::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'pass_status' => $req->pass_status,
					'created_by' => $by,
					'updated_by' => $by,
					'participant_id' => $registration->participant_id,
					'selection_path_id' => $registration->selection_path_id,
					'program_study_id' => $req->program_study_id,
					'specialization_id' => $req->specialization_id,
					'approval_university' => true,
					'approval_university_by' => $by,
					'approval_university_at' => Carbon::now()
				]
			);

			$registration_result = Registration_Result::select('*')
				->where('registration_number', '=', $req->registration_number)
				->first();

			//daftarin ke new-student
			if ($registration_result->pass_status == true) {
				$this->CreateOrUpdateNewStudent($registration_result->registration_number, $registration_result->participant_id, $registration_result->program_study_id, $by);
			}

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function CreateorUpdateRegistrationResult(Request $req) //update kelulusan
	{
		//validate registration before insert
		$isUpdate = Registration_Result::where('registration_number', '=', $req->registration_number)
			->first();

		if ($isUpdate == null) {
			$sync = "INSERT";
		} else {
			$sync = "UPDATE";
		}

		try {
			$by = $req->header("X-I");
			Registration_Result::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'total_score' => ($req->total_score == null) ? $isUpdate->total_score : $req->total_score,
					'pass_status' => ($req->pass_status == null) ? $isUpdate->pass_status : $req->pass_status,
					'publication_status' => ($req->publication_status == null) ? $isUpdate->publication_status : $req->publication_status,
					'publication_date' => ($req->publication_date == null) ? $isUpdate->publication_date : $req->publication_date,
					'council_date' => ($req->council_date == null) ? $isUpdate->council_date : $req->council_date,
					'created_by' => $by,
					'updated_by' => $by,
					'participant_id' => ($req->participant_id == null) ? $isUpdate->participant_id : $req->participant_id,
					'selection_path_id' => ($req->selection_path_id == null) ? $isUpdate->selection_path_id : $req->selection_path_id,
					'program_study_id' => ($req->program_study_id == null) ? $isUpdate->program_study_id : $req->program_study_id,
					'schoolarship_id' => ($req->schoolarship_id == null) ? $isUpdate->schoolarship_id : $req->schoolarship_id,
					'semester' => ($req->semester == null) ? $isUpdate->semester : $req->semester,
					'sks' => ($req->sks == null) ? $isUpdate->sks : $req->sks,
					'specialization_id' => ($req->specialization_id == null) ? $isUpdate->specialization_id : $req->specialization_id,
					'transfer_status' => ($req->transfer_status == null) ? $isUpdate->transfer_status : $req->transfer_status,
					'transfer_program_study_id' => ($req->transfer_program_study_id == null) ? $isUpdate->transfer_program_study_id : $req->transfer_program_study_id,
					'package_id' => ($req->package_id == null) ? $isUpdate->package_id : $req->package_id,
					'payment_method_id' => ($req->payment_method_id == null) ? $isUpdate->payment_method_id : $req->payment_method_id,
					'payment_status' => ($req->payment_status == null) ? $isUpdate->payment_status : $req->payment_status,
					'reference_number' => ($req->reference_number == null) ? $isUpdate->reference_number : $req->reference_number,
					'faculty_number' => ($req->faculty_number == null) ? $isUpdate->faculty_number : $req->faculty_number,
					'spp' => $req->spp,
					'bpp' => $req->bpp,
					'lainnya' => $req->lainnya,
					'ujian' => $req->ujian,
					'praktikum' => $req->praktikum,
					'bppdiscount' => $req->bppdiscount,
					'sppdiscount' => $req->sppdiscount,
					'discount' => $req->discount,
					'notes' => $req->notes,
					'start_date_1' => $req->start_date_1,
					'start_date_2' => $req->start_date_2,
					'start_date_3' => $req->start_date_3,
					'end_date_1' => $req->end_date_1,
					'end_date_2' => $req->end_date_2,
					'end_date_3' => $req->end_date_3,
					'schoolyear' => $req->schoolyear,
					'type' => $req->type,
					'oldstudentid' => $req->oldstudentid,
					'password' => $req->password,
					'created_by' => $by,
					'updated_by' => $by,
					'action' => $sync,
					'total_amount'  => $req->total_amount
				]
			);

			Registration_Result_Sync::create([
				'registration_number' => $req->registration_number,
				'total_score' => $req->total_score,
				'pass_status' => $req->pass_status,
				'publication_status' => $req->publication_status,
				'publication_date' => $req->publication_date,
				'created_by' => $by,
				'participant_id' => $req->participant_id,
				'selection_path_id' => $req->selection_path_id,
				'schoolarship_id' => $req->schoolarship_id,
				'spp' => $req->spp,
				'bpp' => $req->bpp,
				'lainnya' => $req->lainnya,
				'ujian' => $req->ujian,
				'praktikum' => $req->praktikum,
				'bppdiscount' => $req->bppdiscount,
				'sppdiscount' => $req->sppdiscount,
				'discount' => $req->discount,
				'semester' => $req->semester,
				'sks' => $req->sks,
				'notes' => $req->notes,
				'created_by' => $by,
				'updated_by' => $by,
				'start_date_1' => $req->start_date_1,
				'start_date_2' => $req->start_date_2,
				'start_date_3' => $req->start_date_3,
				'end_date_1' => $req->end_date_1,
				'end_date_2' => $req->end_date_2,
				'end_date_3' => $req->end_date_3,
				'schoolyear' => $req->schoolyear,
				'type' => $req->type,
				'oldstudentid' => $req->oldstudentid,
				'reference_number' => $req->reference_number,
				'faculty_number' => $req->faculty_number,
				'password' => $req->password,
				'created_by' => $by,
				'updated_by' => $by,
				'action' => $sync,
				'specialization_id' => $req->specialization_id,
				'package_id'  => $req->package_id,
				'payment_method_id'  => $req->payment_method_id,
				'payment_status'  => $req->payment_status,
				'total_amount'  => $req->total_amount
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function CreateOrUpdateFinalResult(Request $req) //update kelulusan
	{

		try {
			$by = $req->header("X-I");
			Registration_Result::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'publication_status' => $req->publication_status,
					'end_date_1' => $req->end_date_1,
					'publication_date' => $req->publication_date,
					'reference_number' => $req->reference_number,
					'approval_university' => true,
					'approval_university_by' => $by,
					'approval_university_at' => Carbon::now()
				]
			);

			$registration_result = Registration_Result::select('*')
				->where('registration_number', '=', $req->registration_number)
				->first();

			if ($registration_result->pass_status == true) {
				$this->CreateOrUpdateNewStudent($registration_result->registration_number, $registration_result->participant_id, $registration_result->program_study_id, $by);
			}

			Registration_Result_Sync::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'publication_status' => $req->publication_status,
					'end_date_1' => $req->end_date_1,
					'publication_date' => $req->publication_date,
					'reference_number' => $req->reference_number,
				]
			);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function CreateOrUpdateRefundRequest(Request $req) //update kelulusan
	{
		$refund_request = Refund_Request::select('*')
			->where('registration_number', '=', $req->registration_number)
			->first();

		try {
			$by = $req->header("X-I");
			Refund_Request::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'nama' => (isset($req->nama) != null) ? $req->nama : $refund_request->nama ?? '',
					'alamat' => (isset($req->alamat) != null) ? $req->alamat : $refund_request->alamat ?? '',
					'identitas' => (isset($req->identitas) != null) ? $req->identitas : $refund_request->identitas ?? '',
					'no_identitas' => (isset($req->no_identitas) != null) ? $req->no_identitas : $refund_request->no_identitas ?? '',
					'no_rek' => (isset($req->no_rek) != null) ? $req->no_rek : $refund_request->no_rek ?? '',
					'nama_bank' => (isset($req->nama_bank) != null) ? $req->nama_bank : $refund_request->nama_bank ?? '',
					'nama_pemilik' => (isset($req->nama_pemilik) != null) ? $req->nama_pemilik : $refund_request->nama_pemilik ?? '',
					'hubungan_pemilik' => (isset($req->hubungan_pemilik) != null) ? $req->hubungan_pemilik : $refund_request->hubungan_pemilik ?? '',
					'tanggal_transfer' => (isset($req->tanggal_transfer) != null) ? $req->tanggal_transfer : $refund_request->tanggal_transfer ?? null,
					'biaya_paket' => (isset($req->biaya_paket) != null) ? $req->biaya_paket : $refund_request->biaya_paket ?? 0,
					'biaya_admisistrasi' => (isset($req->biaya_admisistrasi) != null) ? $req->biaya_admisistrasi : $refund_request->biaya_admisistrasi ?? 0,
					'biaya_pengembalian' => (isset($req->biaya_pengembalian) != null) ? $req->biaya_pengembalian : $refund_request->biaya_pengembalian ?? 0,
					'reason' => (isset($req->reason) != null) ? $req->reason : $refund_request->reason ?? '',
					'document_url' => ($req->file('document_url') != null) ? env('FTP_URL') . $req->file('document_url')->store('DEV/ADM/Selection/participant/refund') : $refund_request->document_url ?? '',
				]
			);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function CreateOrUpdateChangeProgram(Request $req) //update kelulusan
	{
		$change_programs = Change_Program::select('*')
			->where('registration_number', '=', $req->registration_number)
			->first();

		try {
			$by = $req->header("X-I");
			Change_Program::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'study_programs_id_ex' => (isset($req->study_programs_id_ex) != null) ? $req->study_programs_id_ex : $change_programs->study_programs_id_ex ?? '',
					'study_programs_id' => (isset($req->study_programs_id) != null) ? $req->study_programs_id : $change_programs->study_programs_id ?? '',
					'approval_fakultas' => (isset($req->approval_fakultas) != null) ? $req->approval_fakultas : $change_programs->approval_fakultas ?? '',
					'approval_fakultas_date' => (isset($req->approval_fakultas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
					'approval_fakultas_by' => (isset($req->approval_fakultas) != null) ? $by : $change_programs->approval_fakultas_by ?? '',
					'approval_universitas' => (isset($req->approval_universitas) != null) ? $req->approval_universitas : $change_programs->approval_universitas ?? '',
					'approval_universitas_by' => (isset($req->approval_universitas) != null) ? $by : $change_programs->approval_universitas_by ?? '',
					'approval_universitas_date' => (isset($req->approval_universitas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
				]
			);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	/*
	 Fungsi pembayaran finnet, pakai api InitialFinpayTransaction
	 ada 2 fungsi tambahan yaitu RequestPinTransaction dan createSignature.
	 - RequestPinTransaction (untuk mengirim request ke finnet / finpay)
	 - createSignature (Untuk pembuatan menc_signature atau kode unik pembayaran finnet)
	 */
	public function RequestPinTransaction(Request $req)
	{
		$by = $req->header("X-I");
		$ipfy = '';
		$createVA = '';
		$datajson = '';
		$request_body = '';
		try {
			$client_id = env('CLIENT_ID'); //client id from BNI
			$prefix = env('PREFIX'); //prefix id from BNI
			$secret_key = env('SECRET_VA'); // secret key from BNI
			$trx_id = $this->GenerateFormulirTrxId($req->registration_number);
			$number = str_pad($req->registration_number, 12, '0', STR_PAD_LEFT);
			$va   = $prefix . $client_id . $number;
			// return $va;
			$request_body = array(
				"type"              => 'createbilling',
				"client_id"         => $client_id,
				"trx_id"            => $trx_id,
				"trx_amount"        => $req->amount,
				"billing_type"		=> "c",
				"customer_name"     => $req->participant_name,
				"customer_email"    => $req->participant_email,
				"customer_phone"    => $req->participant_phone_number,
				"virtual_account"   => $va,
				"datetime_expired"  => Carbon::now()->addWeek(1)->format('Y-m-d h:i:s'),
				"description"       => $req->add_info1,
			);
			$hashdata = BniEnc::encrypt($request_body, $client_id, $secret_key);
			$datajson = json_encode(array(
				'client_id' => $client_id,
				'prefix' => $prefix,
				'data' => $hashdata,
			));

			$http = new Client(['verify' => false]);

			if ($req->amount > 0) {
				$request = $http->post(env('URL_CREATE_TRANSACTION_VA'), [
					'body' => $datajson,
					'headers' => [
						'Content-Type' => 'application/json',
						'Origin' => 'String',
					],
					'connect_timeout' => 25
				]);

				$createVA = json_decode($request->getBody(), true);
			}


			if ($req->amount == 0 || $req->amount == null) {
				Registration::where('registration_number', $req->registration_number)->update([
					'payment_status_id' => 1,
					// 'payment_receipt_status' => "Lunas",
					'payment_date' => Carbon::now(),
					'payment_url' => "Free",
				]);
			}

			if (isset($createVA['data']) && $req->amount > 0) {
				$parsedata = BniEnc::decrypt($createVA['data'], $client_id, $secret_key);

				$dataToSend['va_number'] = $req->registration_number;
				$dataToSend['trx_amount'] = $req->amount;
				$dataToSend['customer_name'] = $req->participant_name;
				$dataToSend['customer_email'] = $req->participant_email;
				$dataToSend['customer_phone'] = $req->participant_phone_number;
				$dataToSend['datetime_expired'] = Carbon::now()->addWeek(1)->format('Y-m-d h:i:s');
				$dataToSend['description'] = $req->add_info1;

				Transaction_Request::create([
					'client_id' => $client_id,
					'trx_amount' => $dataToSend['trx_amount'],
					'customer_name' => $dataToSend['customer_name'],
					'customer_email' => $dataToSend['customer_email'],
					'customer_phone' => $dataToSend['customer_phone'],
					'virtual_account' => $parsedata['virtual_account'],
					'trx_id' => $parsedata['trx_id'],
					'datetime_expired' => $dataToSend['datetime_expired'],
					'description' => $dataToSend['description'],
					'type' => 'createBilling',
					'json_response' => json_encode($parsedata),
					'created_by' => $by,
					'registration_number' => $req->registration_number
				]);

				$email = $req->participant_email;
				$name = $req->participant_name;

				$data = [
					'virtual_account' => $parsedata['virtual_account'],
					'expiredat' => $dataToSend['datetime_expired'],
					'noreg' => $req->registration_number,
				];

				Mail::send('virtual_account_mail', $data, function ($message) use ($email, $name) {
					$message->to($email, $name)->subject('Trisakti University Admission');
				});

				return response()->json([
					'status' => 'Success',
					'message' => 'Berhasil membuat VA',
					'result' => $parsedata
				], 200);
			} else {
				// return response()->json([
				// 	'status' => 'Success',
				// 	'message' => 'Berhasil membuat VA',
				// 	'response' => $createVA
				// ], 200);
				return response()->json([
					'status' => 'Failed',
					'message' => 'Gagal membuat VA / Tidak Menemukan Tagihan!',
					'response' => $createVA
				], 400);
			}

			// $ipfy = json_decode($http->request('GET', 'https://api64.ipify.org?format=json', [
			// 	'connect_timeout' => 25
			// ])->getBody(), true);
		} catch (\Throwable $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'data' => $createVA,
				'result' => $e->getMessage()
			], 500);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'data' => $createVA,
				'result' => $e->getMessage()
			], 500);
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'data' => $createVA,
				'result' => $e->getMessage()
			], 500);
		}
	}

	public function RequestPinTransactionBackup(Request $req)
	{
		$by = $req->header("X-I");
		$token = $req->token;

		$dataToSend['va_number'] = $req->registration_number;
		$dataToSend['trx_amount'] = $req->amount;
		$dataToSend['customer_name'] = $req->participant_name;
		$dataToSend['customer_email'] = $req->participant_email;
		$dataToSend['customer_phone'] = $req->participant_phone_number;
		$dataToSend['datetime_expired'] = Carbon::now()->addWeek(1)->format('Y-m-d h:i:s');
		$dataToSend['description'] = $req->add_info1;

		try {
			//url transaction va
			$url = env('URL_CREATE_TRANSACTION_VA');

			$http = new Client(['verify' => false]);

			$request = $http->post($url, [
				'form_params' => $dataToSend,
				'headers' => [
					'Authorization' => 'Bearer ' . $token
				]
			]);

			$response = json_decode($request->getBody(), true);

			//validate response status
			if (isset($response['status'])) {
				return response()->json([
					'status' => 'Failed',
					'code' => $response['status'],
					'message' => $response['status'],
					'response' => $response
				], 500);
			}

			Transaction_Request::create([
				'client_id' => $response['request_body']['client_id'],
				'trx_amount' => $response['request_body']['trx_amount'],
				'customer_name' => $response['request_body']['customer_name'],
				'customer_email' => $response['request_body']['customer_email'],
				'customer_phone' => $response['request_body']['customer_phone'],
				'virtual_account' => $response['request_body']['virtual_account'],
				'trx_id' => $response['request_body']['trx_id'],
				'datetime_expired' => $response['request_body']['datetime_expired'],
				'description' => $response['request_body']['description'],
				'type' => $response['request_body']['type'],
				'prefix' => $response['body_encrypt']['prefix'],
				'data' => $response['body_encrypt']['data'],
				'ipfy' => $response['ipfy']['ip'],
				'ip' => $response['ip'],
				'ip_remote' => $response['ip_remote'],
				'name_remote' => $response['name_remote'],
				'json_response' => json_encode($response),
				'created_by' => $by,
				'registration_number' => $req->registration_number
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Transaction Success',
				'result' => $response
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'result' => $e->getMessage()
			], 500);
		}
	}

	//fungsi untuk mengirimkan invoice ke email
	function sendTransactionToEmail($dataToSend)
	{
		$http = new \GuzzleHttp\Client;
		$url = 'https://api.telkomuniversity.ac.id/email/send';

		$email['username'] = $dataToSend['cust_email'];
		$email['name'] = $dataToSend['cust_name'];
		$total = number_format($dataToSend['amount'], 0, '.', '.');

		$due = date("d F Y - H:i", strtotime($dataToSend['trans_date'] . ' + 720 minute'));

		$message = 'Dear ' . $email['name'] . ',<br><br>

					Hello! <br>
					This is an invoice for your recent purchase.<br>
					Invoice Number : ' . $dataToSend['invoice'] . '<br>
					Total : Rp ' . $total . '<br>
					Payment Due : <b>' . $due . '</b><br><br>

					Please do not reply to this message. <br>
					If you have any questions, please contact us by email (info@smbbtelkom.ac.id).<br><br>
					Thanks and Regards,<br>
					<b>TELKOM UNIVERSITY Admission Team</b><br><br>';

		$param = array(
			'to' => $email['username'],
			'subject' => 'Telkom University Admission',
			'content' => $message,
			'toname' => $email['name'],
			'fromname' => 'Telkom University Admission Team'
		);

		$response = $http->post($url, ['auth' => ['igracias', 'v01DSp!r1T'], 'form_params' => $param]);

		return $response;
	}

	//generate voucher
	public function InsertPinVoucher(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$create = Pin_Voucher::create([
				'voucher' => strtoupper(Str::random(8)),
				'study_program_id' => $req->study_program_id,
				'description' => $req->description,
				'type' => strtoupper($req->type),
				'expire_date' => $req->expire_date,
				'active_status' => false,
				'price' => $req->price,
				'created_by' => $by,
				'updated_by' => $by
			]);

			DB::connection('pgsql')->commit();

			return response([
				'status' => 'Success',
				'message' => 'Voucher Tersimpan',
				'voucher' => $create
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'exception_message' => $e->getMessage()
			], 500);
		}
	}

	public function TransactionPaymentWithVoucher(Request $req)
	{
		$by = $req->header("X-I");

		//validate form-data
		if ($req->voucher == null || $req->registration_number == null) {
			return response()->json([
				"status" => "Failed",
				"message" => "empty form-data",
			], 400);
		}

		//validate voucher
		$voucher = Pin_Voucher::where('voucher', '=', $req->voucher)->first();

		if ($voucher == null || $voucher->active_status != true || $voucher->expire_date < date('Y-m-d')) {
			return response()->json([
				"status" => "Failed",
				"message" => "Voucher invalid or expired",
			], 400);
		}

		//update registration
		try {

			//update voucher
			try {

				Transaction_Voucher::create([
					'voucher' => $req->voucher,
					'registration_number' => $req->registration_number,
					'created_by' => $by,
					'updated_by' => $by
				]);

				return response()->json([
					"status" => "Success",
					"message" => "Registration update successfully"
				], 200);
			} catch (\Exception $ev) {
				return response()->json([
					"status" => "Failed",
					"message" => "Registration has updated but voucher not updated",
					"exception" => $ev->getMessage()
				], 500);
			}
		} catch (\Exception $e) {
			return response()->json([
				"status" => "Failed",
				"message" => "Failed to update registration",
				"exception" => $e->getMessage()
			], 500);
		}
	}

	//untuk insert excel surat kelulusan
	public function InsertBulkRegistrationResultExcel(Request $req)
	{
		try {
			$by = $req->header("X-I");
			Excel::import(new RegistrationResultBulk($by), $req->file('excel')->getRealPath());

			return response()->json(['message' => 'Success Import Registration Result'], 200);
		} catch (Exception $e) {
			return response()->json(['message' => 'Ada Nomor Registrasi yang tidak terdaftar atau kosong.', 'error' => $e->getMessage()], 500);
		}
	}

	public function InsertBulkParticipantExcel(Request $req)
	{
		$by = $req->header("X-I");
		try {
			Excel::import(new ParticipantBulk($by), $req->file('excel')->getRealPath());

			return response()->json(['message' => 'Success Import Participant'], 200);
		} catch (Throwable $e) {
			return response()->json(['message' => 'Failed Import Participant', 'error' => $e->getMessage()], 500);
		}
	}

	//api for creating insert mapping path year
	public function InsertMappingPathYear(Request $req)
	{
		try {
			$by = $req->header("X-I");

			Mapping_Path_Year::create([
				'selection_path_id' => $req->selection_path_id,
				'year' => $req->year,
				'school_year' => $req->school_year,
				'active_status' => $req->active_status,
				'created_by' => $by,
				'start_date' => $req->start_date,
				'end_date' => $req->end_date
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil membuat data Mapping path year'
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal membuat mapping path year.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating insert mapping path year
	public function InsertMappingPathYearIntake(Request $req)
	{
		try {
			$by = $req->header("X-I");

			Mapping_Path_Year_Intake::create([
				'mapping_path_year_id' => $req->mapping_path_year_id,
				'semester' => $req->semester,
				'school_year' => $req->school_year,
				'notes' => $req->notes,
				'nomor_reff' => $req->nomor_reff,
				'created_by' => $by,
				'active_status' => true,
				'year' => $req->year
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil membuat data Mapping path year intake'
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal membuat mapping path year intake.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating document recomendation
	public function InsertIntoDocumentRecomendation(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$document = Document::Create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->document_name,
				'description' => $req->description,
				'created_by' => $by
			]);
			$document_recomendation = Document_Recomendation::Create(
				[
					'document_id' => $document->id,
					'registration_number' => ($req->registration_number) ? $req->registration_number : null,
					'name' => ($req->name) ? $req->name : null,
					'handphone' => ($req->handphone) ? $req->handphone : null,
					'email' => ($req->email) ? $req->email : null,
					'position' => ($req->position) ? $req->position : null,
					'token' => Str::random(8)
				]
			);

			//generate url
			$hash = Hash::make($document_recomendation->id);
			$code = $document_recomendation->token;

			$url = env('URL_ACCESS') . "/recommendation/?code=$code&hash=$hash";

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
				'url' => $url
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'url' => null,
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for insert announcement
	public function InsertAnnoncementRegistrationCard(Request $req)
	{
		try {
			$by = $req->header("X-I");

			Announcement_Registration_Card::create([
				'tittle' => $req->title,
				'start_date' => $req->start_date,
				'notes' => $req->notes,
				'selection_program_category' => "INTERNATIONAL",
				'active_status' => $req->active_status,
				'ordering' => $req->ordering,
				'exam_type' => $req->exam_type,
				'created_by' => $by,
				'updated_by' => $by
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil membuat data pengumuman'
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal membuat data pengumuman.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for insert mapping report subject path
	public function InsertMappingReportSubjectPath(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$datas = json_decode($req->json, true);

			//insert to mapping path document
			Mapping_Path_Document::updateOrCreate(
				[
					'selection_path_id' => $datas['selection_path_id'],
					'document_type_id' => $datas['document_type_id']
				],
				[
					'selection_path_id' => $datas['selection_path_id'],
					'document_type_id' => $datas['document_type_id'],
					'active_status' => $datas['active_status'],
					'required' => $datas['required'],
					'created_by' => $by
				]
			);

			//insert technic
			Mapping_Report_Subject_Path::updateOrCreate(
				[
					'selection_path_id' => $datas['selection_path_id'],
					'is_technic' => true
				],
				[
					'selection_path_id' => $datas['selection_path_id'],
					'is_technic' => true,
					'math' => $datas['mapping_report_subject_path_technic']['math'],
					'physics' => $datas['mapping_report_subject_path_technic']['physics'],
					'biology' => $datas['mapping_report_subject_path_technic']['biology'],
					'chemical' => $datas['mapping_report_subject_path_technic']['chemical'],
					'bahasa' => $datas['mapping_report_subject_path_technic']['bahasa'],
					'english' => $datas['mapping_report_subject_path_technic']['english'],
					'economy' => $datas['mapping_report_subject_path_technic']['economy'],
					'geography' => $datas['mapping_report_subject_path_technic']['geography'],
					'sociological' => $datas['mapping_report_subject_path_technic']['sociological'],
					'historical' => $datas['mapping_report_subject_path_technic']['historical'],
					'created_by' => $by,
					'active_status' => true
				]
			);

			//insert non technic
			Mapping_Report_Subject_Path::updateOrCreate(
				[
					'selection_path_id' => $datas['selection_path_id'],
					'is_technic' => false,
				],
				[
					'selection_path_id' => $datas['selection_path_id'],
					'is_technic' => false,
					'math' => $datas['mapping_report_subject_path_non_technic']['math'],
					'physics' => $datas['mapping_report_subject_path_non_technic']['physics'],
					'biology' => $datas['mapping_report_subject_path_non_technic']['biology'],
					'chemical' => $datas['mapping_report_subject_path_non_technic']['chemical'],
					'bahasa' => $datas['mapping_report_subject_path_non_technic']['bahasa'],
					'english' => $datas['mapping_report_subject_path_non_technic']['english'],
					'economy' => $datas['mapping_report_subject_path_non_technic']['economy'],
					'geography' => $datas['mapping_report_subject_path_non_technic']['geography'],
					'sociological' => $datas['mapping_report_subject_path_non_technic']['sociological'],
					'historical' => $datas['mapping_report_subject_path_non_technic']['historical'],
					'created_by' => $by,
					'active_status' => true
				]
			);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil membuat data'
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal membuat data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//function for create session in path exam details
	public function CreateOrUpdatePathExamDetailSession(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$data = Path_Exam_Detail::find($req->id);

			Path_Exam_Detail::find($req->id)->update([
				'session_one_start' => ($req->session_one_start) ? $req->session_one_start : $data->session_one_start,
				'session_two_start' => ($req->session_two_start) ? $req->session_two_start : $data->session_two_start,
				'session_three_start' => ($req->session_three_start) ? $req->session_three_start : $data->session_three_start,
				'session_one_end' => ($req->session_one_end) ? $req->session_one_end : $data->session_one_end,
				'session_two_end' => ($req->session_two_end) ? $req->session_two_end : $data->session_two_end,
				'session_three_end' => ($req->session_three_end) ? $req->session_three_end : $data->session_three_end,
				'location' => ($req->location) ? $req->location : $data->location,
				'updated_by' => $by
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil memperbaruhi data'
			], 200);
		} catch (Exception $e) {

			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api untuk insert data passing grade
	public function InsertIntoPassingGrade(Request $req)
	{
		$by = $req->header("X-I");

		try {
			Passing_Grade::create([
				'program_study_id' => $req->program_study_id,
				'mapping_path_year_id' => $req->mapping_path_year_id,
				'created_by' => $by,
				'active_status' => $req->active_status,
				'min_grade_value' => $req->min_grade_value,
				'mapel1' => $req->mapel1,
				'mapel2' => $req->mapel2,
				'mapel3' => $req->mapel3,
				'mapel4' => $req->mapel4,
				'mapel5' => $req->mapel5,
				'mapel6' => $req->mapel6,
				'mapel7' => $req->mapel7,
				'mapel8' => $req->mapel8,
				'mapel9' => $req->mapel9,
				'mapel10' => $req->mapel10,
				'mapel11' => $req->mapel11,
				'mapel12' => $req->mapel12,
				'mapel13' => $req->mapel13,
				'mapel14' => $req->mapel14,
				'mapel15' => $req->mapel15,
				'mapel16' => $req->mapel16,
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil menambah data'
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal menambah data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api untuk insert data passing grade
	public function UpdateOrCreateParticipantGrade(Request $req)
	{
		$by = $req->header("X-I");

		try {
			Participant_Grade::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'registration_number' => $req->registration_number,
					'mapel1' => $req->mapel1,
					'mapel2' => $req->mapel2,
					'mapel3' => $req->mapel3,
					'mapel4' => $req->mapel4,
					'mapel5' => $req->mapel5,
					'mapel6' => $req->mapel6,
					'mapel7' => $req->mapel7,
					'mapel8' => $req->mapel8,
					'mapel9' => $req->mapel9,
					'mapel10' => $req->mapel10,
					'mapel11' => $req->mapel11,
					'mapel12' => $req->mapel12,
					'mapel13' => $req->mapel13,
					'mapel14' => $req->mapel14,
					'mapel15' => $req->mapel15,
					'mapel16' => $req->mapel16,
					'created_by' => $by,
					'updated_by' => $by,
					'grade_final' => $req->grade_final
				]
			);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil memperbaruhi data'
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle categories
	public function InsertMoodleCategoryBackup(Request $req)
	{
		$by = $req->header("X-I");

		//get selection path
		$selection_path = Selection_Path::select('*')->where('id', '=', $req->selection_path_id)->first();

		//validate selection path
		if ($selection_path == null) {
			return response([
				'status' => 'Failed',
				'message' => 'Jalur seleksi tidak terdaftar di dalam database'
			], 500);
		}

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_categories';

			//categories must be array, because moodle required array
			$formParam['categories'][0]['name'] = $selection_path->name;
			$formParam['categories'][0]['idnumber'] = $selection_path->id;
			$formParam['categories'][0]['description'] = 'Kategori Jalur ' . $selection_path->name;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['id'] == 0) {
				return response([
					'status' => 'Failed',
					'message' => 'Jalur seleksi sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			Moodle_Categories::create([
				'id' => $response['data'][0]['id'],
				'name' => $selection_path->name,
				'selection_path_id' => $selection_path->id,
				'description' => $formParam['categories'][0]['description'],
				'json_response' => json_encode($response),
				'created_by' => $by
			]);

			return response([
				'status' => 'Success',
				'message' => 'Jalur seleksi didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan jalur seleksi kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle categories
	public function InsertMoodleCategory(Request $req)
	{
		$by = $req->header("X-I");

		//get selection path
		$selection_path = Selection_Path::select('*')->where('id', '=', $req->selection_path_id)->first();

		//validate selection path
		if ($selection_path == null) {
			return response([
				'status' => 'Failed',
				'message' => 'Jalur seleksi tidak terdaftar di dalam database'
			], 500);
		}

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_categories';

			//categories must be array, because moodle required array
			$formParam['categories'][0]['name'] = $selection_path->name;
			$formParam['categories'][0]['idnumber'] = $selection_path->id;
			$formParam['categories'][0]['description'] = 'Kategori Jalur ' . $selection_path->name;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['status'] == true) {
				// validate id
				if ($response['data'][0]['id'] == 0 || $response['data'][0]['id'] == "0" || $response['data'][0]['id'] == null) {
					$id = $response['data'][0]['idnumber'];
				} else {
					$id = $response['data'][0]['id'];
				}

				Moodle_Categories::updateOrCreate(
					[
						'id' => $id,
						'name' => $selection_path->name,
						'selection_path_id' => $selection_path->id,
						'description' => $formParam['categories'][0]['description']
					],
					[
						'id' => $id,
						'name' => $selection_path->name,
						'selection_path_id' => $selection_path->id,
						'description' => $formParam['categories'][0]['description'],
						'json_response' => json_encode($response),
						'created_by' => $by
					]
				);

				return response([
					'status' => 'Success',
					'message' => 'Jalur seleksi didaftarkan dalam moodle',
					'response' => $response
				], 200);
			} else {
				return response([
					'status' => 'Failed',
					'test' => 'else',
					'message' => 'Jalur seleksi gagal didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan jalur seleksi kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle categories
	public function InsertMoodleCourseBackup($selection_path_id, $path_exam_detail, $by)
	{
		//get selection path
		$moodle_category = Moodle_Categories::select(
			'moodle_categories.*',
			'sp.name as selection_path'
		)
			->join('selection_paths as sp', 'moodle_categories.selection_path_id', '=', 'sp.id')
			->where('moodle_categories.selection_path_id', '=', $selection_path_id)
			->first();

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_courses';

			$month_year_exam = Carbon::createFromTimestamp(strtotime($path_exam_detail->exam_start_date))->format('F Y');

			//categories must be array, because moodle required array
			$formParam['courses'][0]['shortname'] = $moodle_category->selection_path . " " . $month_year_exam;
			$formParam['courses'][0]['fullname'] = "Course " . $moodle_category->selection_path . " " . $month_year_exam;
			$formParam['courses'][0]['idnumber'] = Moodle_Courses::GetNextAutoIncrementMoodleCourse();
			$formParam['courses'][0]['categoryid'] = $moodle_category->selection_path_id;
			$formParam['courses'][0]['summary'] = "Description " . $moodle_category->name . " " . $month_year_exam;
			$formParam['courses'][0]['startdate'] = strtotime($path_exam_detail->exam_start_date . " 00:00:00");
			$formParam['courses'][0]['enddate'] = strtotime($path_exam_detail->exam_start_date . " 23:59:59");
			$formParam['courses'][0]['groupmode'] = 0;
			$formParam['courses'][0]['groupmodeforce'] = 1;
			$formParam['courses'][0]['enablecompletion'] = 1;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			Moodle_Courses::create([
				'id' => $response['data'][0]['idnumber'],
				'category_id' => $formParam['courses'][0]['categoryid'],
				'shortname' => $formParam['courses'][0]['shortname'],
				'fullname' => $formParam['courses'][0]['fullname'],
				'selection_path_id' => $moodle_category->selection_path_id,
				'summary' => $formParam['courses'][0]['summary'],
				'startdate' => $formParam['courses'][0]['startdate'],
				'enddate' => $formParam['courses'][0]['enddate'],
				'group_mode' => $formParam['courses'][0]['groupmode'],
				'group_mode_force' => $formParam['courses'][0]['groupmodeforce'],
				'enable_completion' => $formParam['courses'][0]['enablecompletion'],
				'json_response' => json_encode($response),
				'path_exam_detail_id' => $path_exam_detail->id,
				'created_by' => $by
			]);

			return [
				'success' => true,
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			];
		} catch (\Exception $e) {
			return [
				'success' => false,
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			];
		}
	}

	//api for creating moodle categories
	public function InsertMoodleCourse(Request $req)
	{
		$by = $req->header("X-I");

		//get selection path
		$moodle_category = Moodle_Categories::select(
			'moodle_categories.*',
			'sp.name as selection_path'
		)
			->join('selection_paths as sp', 'moodle_categories.selection_path_id', '=', 'sp.id')
			->where('moodle_categories.id', '=', $req->moodle_category_id)
			->first();

		//validate selection path
		if ($moodle_category == null) {
			return response([
				'status' => 'Failed',
				'message' => 'Data tidak terdaftar dalam database'
			], 500);
		}

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_courses';

			$month_exam = Carbon::createFromTimestamp(strtotime($req->start_date))->format('F');

			//categories must be array, because moodle required array
			$formParam['courses'][0]['shortname'] = $moodle_category->selection_path . " " . $month_exam;
			$formParam['courses'][0]['fullname'] = "Course " . $moodle_category->selection_path . " " . $month_exam;
			$formParam['courses'][0]['idnumber'] = Moodle_Courses::GetNextAutoIncrementMoodleCourse();
			$formParam['courses'][0]['categoryid'] = $moodle_category->selection_path_id;
			$formParam['courses'][0]['summary'] = "Description " . $moodle_category->name . " " . $month_exam;
			$formParam['courses'][0]['startdate'] = strtotime(Carbon::parse($req->end_date)->addHours(-24)->format("Y-m-d H:i:s")); //tanggal ujian menjadi h-1
			$formParam['courses'][0]['enddate'] = strtotime($req->end_date);

			//validate image banner
			if (isset($req->image))
				$formParam['courses'][0]['image'] = env('FTP_URL') . $req->file('image')->store('DEV/ADM/Selection/moodle/courses');

			//validate index_name
			if ($req->index_name)
				$formParam['courses'][0]['indexname'] = $req->index_name;

			$formParam['courses'][0]['groupmode'] = 0;
			$formParam['courses'][0]['groupmodeforce'] = 1;
			$formParam['courses'][0]['enablecompletion'] = 1;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['id'] == 0) {
				return response([
					'status' => 'Failed',
					'message' => 'Data sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			Moodle_Courses::create([
				'id' => $response['data'][0]['idnumber'],
				'category_id' => $formParam['courses'][0]['categoryid'],
				'shortname' => $formParam['courses'][0]['shortname'],
				'fullname' => $formParam['courses'][0]['fullname'],
				'selection_path_id' => $moodle_category->selection_path_id,
				'summary' => $formParam['courses'][0]['summary'],
				'startdate' => $formParam['courses'][0]['startdate'],
				'enddate' => $formParam['courses'][0]['enddate'],
				'image' => (isset($req->image) == null) ? null : $formParam['courses'][0]['image'],
				'group_mode' => $formParam['courses'][0]['groupmode'],
				'group_mode_force' => $formParam['courses'][0]['groupmodeforce'],
				'enable_completion' => $formParam['courses'][0]['enablecompletion'],
				'json_response' => json_encode($response),
				'path_exam_detail_id' => $req->path_exam_detail_id,
				'created_by' => $by
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle user
	public function InsertMoodleUser(Request $req)
	{
		$by = $req->header("X-I");

		//get participant data
		$participant = Participant::select(
			'participants.id',
			'participants.fullname',
			'participants.username as email',
			'participants.photo_url',
			'participants.identify_number'
		)
			->where('participants.id', '=', $req->participant_id)
			->first();

		try {
			//initialize moodle
			CBT_Package_Question_Users::create([
				'package_question_id' => 1,
				'user_id' => $participant->identify_number,
				'classes' => "Reguler",
				'date_exam' => "2024-10-01 08:00:00",
				'date_start' => "2024-10-01 08:00:00",
				'date_end' => "2024-10-10 23:00:00",
				'status' => 1
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle section
	public function InsertMoodleSection(Request $req)
	{
		$by = $req->header("X-I");

		//get participant data
		$moodle_course = Moodle_Courses::select(
			'id'
		)
			->where('id', '=', $req->moodle_course_id)
			->first();

		//validate selection path
		if ($moodle_course == null) {
			return response([
				'status' => 'Failed',
				'message' => 'Data tidak terdaftar dalam database'
			], 500);
		}

		//validate section name
		if (!isset($req->section_name)) {
			return response([
				'status' => 'Failed',
				'message' => 'Field section_name required'
			], 500);
		}

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_sections';

			$formParam['sections'][0]['course'] = $moodle_course->id;
			$formParam['sections'][0]['name'] = $req->section_name;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Data sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			Moodle_Sections::create([
				'id' => $response['data'][0]['id'],
				'moodle_course_id' => $formParam['sections'][0]['course'],
				'name' => $formParam['sections'][0]['name'],
				'json_response' => json_encode($response),
				'created_by' => $by,
				'type' => (int) filter_var($formParam['sections'][0]['name'], FILTER_SANITIZE_NUMBER_INT) //for type (1,2,3) session
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle group
	public function InsertMoodleGroup(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$datas = json_decode($req->json, true);

			$path_exam_detail = Path_Exam_Detail::select(
				'path_exam_details.*',
				'sp.name as selection_path_name'
			)
				->join('selection_paths as sp', 'path_exam_details.selection_path_id', '=', 'sp.id')
				->where('path_exam_details.id', '=', $datas['path_exam_detail_id'])
				->first();

			$time_exam = Carbon::parse($path_exam_detail->exam_start_date)->format("Y-m-d");

			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_groups';

			$formParam['groups'][0]['courseid'] = $datas['moodle_course_id'];
			$formParam['groups'][0]['idnumber'] = Moodle_Groups::GetNextAutoIncrementMoodleCourse();
			$formParam['groups'][0]['name'] = 'Grup Teknik ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][0]['idnumber'] . ')';
			$formParam['groups'][0]['description'] = 'Group Pilihan Prodi Teknik ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][0]['idnumber'] . ')';
			$formParam['groups'][0]['starttime'] = strtotime($time_exam . ' ' . $path_exam_detail->session_one_start);
			$formParam['groups'][0]['sections'][0]['id'] = $datas['sections'][0]['moodle_section_id'];
			$formParam['groups'][0]['sections'][1]['id'] = $datas['sections'][1]['moodle_section_id'];

			$formParam['groups'][1]['courseid'] = $datas['moodle_course_id'];
			$formParam['groups'][1]['idnumber'] = Moodle_Groups::GetNextAutoIncrementMoodleCourse();
			$formParam['groups'][1]['name'] = 'Grup Non Teknik ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][1]['idnumber'] . ')';
			$formParam['groups'][1]['description'] = 'Group Pilihan Prodi Non Teknik ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][1]['idnumber'] . ')';
			$formParam['groups'][1]['starttime'] = strtotime($time_exam . ' ' . $path_exam_detail->session_two_start);
			$formParam['groups'][1]['sections'][0]['id'] = $datas['sections'][1]['moodle_section_id'];

			$formParam['groups'][2]['courseid'] = $datas['moodle_course_id'];
			$formParam['groups'][2]['idnumber'] = Moodle_Groups::GetNextAutoIncrementMoodleCourse();
			$formParam['groups'][2]['name'] = 'Grup Art ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][2]['idnumber'] . ')';
			$formParam['groups'][2]['description'] = 'Group Pilihan Prodi Art ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][2]['idnumber'] . ')';
			$formParam['groups'][2]['starttime'] = strtotime($time_exam . ' ' . $path_exam_detail->session_three_start);
			$formParam['groups'][2]['sections'][0]['id'] = $datas['sections'][2]['moodle_section_id'];

			$formParam['groups'][3]['courseid'] = $datas['moodle_course_id'];
			$formParam['groups'][3]['idnumber'] = Moodle_Groups::GetNextAutoIncrementMoodleCourse();
			$formParam['groups'][3]['name'] = 'Grup Teknik, Non Teknik dan Art ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][3]['idnumber'] . ')';
			$formParam['groups'][3]['description'] = 'Group Pilihan Prodi Teknik, Non Teknik dan Art ' . $path_exam_detail->selection_path_name . '(' . $formParam['groups'][3]['idnumber'] . ')';
			$formParam['groups'][3]['starttime'] = strtotime($time_exam . ' ' . $path_exam_detail->session_one_start);
			$formParam['groups'][3]['sections'][0]['id'] = $datas['sections'][2]['moodle_section_id'];

			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			Moodle_Groups::create([
				'id' => $response['data'][0]['idnumber'],
				'moodle_course_id' => $formParam['groups'][0]['courseid'],
				'name' => $formParam['groups'][0]['name'],
				'description' => $formParam['groups'][0]['description'],
				'starttime' => $formParam['groups'][0]['starttime'],
				'sections' => json_encode($formParam['groups'][0]['sections']),
				'json_response' => json_encode($response),
				'created_by' => $by,
				'exam_group_id' => 1
			]);

			Moodle_Groups::create([
				'id' => $response['data'][1]['idnumber'],
				'moodle_course_id' => $formParam['groups'][1]['courseid'],
				'name' => $formParam['groups'][1]['name'],
				'description' => $formParam['groups'][1]['description'],
				'starttime' => $formParam['groups'][1]['starttime'],
				'sections' => json_encode($formParam['groups'][1]['sections']),
				'json_response' => json_encode($response),
				'created_by' => $by,
				'exam_group_id' => 2
			]);

			Moodle_Groups::create([
				'id' => $response['data'][2]['idnumber'],
				'moodle_course_id' => $formParam['groups'][2]['courseid'],
				'name' => $formParam['groups'][2]['name'],
				'description' => $formParam['groups'][2]['description'],
				'starttime' => $formParam['groups'][2]['starttime'],
				'sections' => json_encode($formParam['groups'][2]['sections']),
				'json_response' => json_encode($response),
				'created_by' => $by,
				'exam_group_id' => 3
			]);

			Moodle_Groups::create([
				'id' => $response['data'][3]['idnumber'],
				'moodle_course_id' => $formParam['groups'][3]['courseid'],
				'name' => $formParam['groups'][3]['name'],
				'description' => $formParam['groups'][3]['description'],
				'starttime' => $formParam['groups'][3]['starttime'],
				'sections' => json_encode($formParam['groups'][3]['sections']),
				'json_response' => json_encode($response),
				'created_by' => $by,
				'exam_group_id' => 4
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle member
	public function InsertMoodleMember(Request $req)
	{
		$by = $req->header("X-I");

		$group_ids = $req->moodle_group_ids;
		$group_ids = explode(",", $group_ids);

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_add_group_members';

			for ($i = 0; $i < count($group_ids); $i++) {

				$group = Moodle_Groups::find($group_ids[$i]);

				$formParam['members'][$i]['groupid'] = $group_ids[$i];
				$formParam['members'][$i]['userid'] = $req->moodle_user_id;
				// $formParam['members'][$i]['courseid'] = $group->moodle_course_id;
			}

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Data sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			for ($i = 0; $i < count($group_ids); $i++) {
				Moodle_Members::updateOrCreate(
					[
						'moodle_group_id' => $group_ids[$i],
						'moodle_user_id' => $req->moodle_user_id,

					],
					[
						'moodle_group_id' => $group_ids[$i],
						'moodle_user_id' => $req->moodle_user_id,
						'json_response' => json_encode($response),
						'created_by' => $by
					]
				);
			}

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle member
	public function InsertMoodleMemberBackup(Request $req)
	{
		$by = $req->header("X-I");

		$group_ids = $req->moodle_group_ids;
		$group_ids = explode(",", $group_ids);

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_add_group_members';

			for ($i = 0; $i < count($group_ids); $i++) {
				$formParam['members'][$i]['groupid'] = $group_ids[$i];
				$formParam['members'][$i]['userid'] = $req->moodle_user_id;
				// $formParam['members'][$i]['courseid'] = $req->moodle_user_id;
			}

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Data sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			for ($i = 0; $i < count($group_ids); $i++) {
				Moodle_Members::updateOrCreate(
					[
						'moodle_group_id' => $group_ids[$i],
						'moodle_user_id' => $req->moodle_user_id,

					],
					[
						'moodle_group_id' => $group_ids[$i],
						'moodle_user_id' => $req->moodle_user_id,
						'json_response' => json_encode($response),
						'created_by' => $by
					]
				);
			}

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for insert mapping utbk path
	public function InsertMappingUtbkPath(Request $req)
	{
		try {
			$by = $req->header("X-I");

			Mapping_Utbk_Path::updateOrCreate(
				[
					// 'selection_path_id' => $req->selection_path_id,
					// 'program_study_id' => $req->program_study_id,
					'id' => $req->id,
				],
				[
					'selection_path_id' => $req->selection_path_id,
					'program_study_id' => $req->program_study_id,
					'is_science' => $req->is_science,
					'name' => $req->name,
					'mapel1' => $req->mapel1,
					'mapel2' => $req->mapel2,
					'mapel3' => $req->mapel3,
					'mapel4' => $req->mapel4,
					'mapel5' => $req->mapel5,
					'mapel6' => $req->mapel6,
					'mapel7' => $req->mapel7,
					'mapel8' => $req->mapel8,
					'mapel9' => $req->mapel9,
					'mapel10' => $req->mapel10,
					'created_by' => $by,
					'active_status' => true
				]
			);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil membuat data'
			], 200);
		} catch (Throwable $e) {
			return $e->getMessage();
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal membuat data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle enrollment
	public function InsertMoodleEnrollment(Request $req)
	{
		/*
			Ketika proses insert data enrollment maka harus divalidasi lagi dari database
			ketika data sudah ada maka tidak boleh insert ulang ke moodle
			*/

		$by = $req->header("X-I");

		try {
			//ambil semua data ids yang diinputkan dari body dan masukkan kedalam perulangan
			$group_ids = $req->moodle_group_ids;
			$group_ids = explode(",", $group_ids);

			$enrollements_push = array();

			for ($i = 0; $i < count($group_ids); $i++) {

				$check = Moodle_Enrollments::select('*')
					->where('moodle_user_id', '=', $req->moodle_user_id)
					->where('moodle_course_id', '=', $req->moodle_course_id)
					->where('moodle_group_id', '=', $group_ids[$i])
					->first();

				if ($check == null) {
					$group = Moodle_Groups::select()
						->where('id', '=', $group_ids[$i])
						->first();

					//time startnya ngambil tanggal cetak kartu peserta
					array_push($enrollements_push, [
						'userid' => $req->moodle_user_id,
						'courseid' => $req->moodle_course_id,
						'roleid' => 5,
						'timestart' => strtotime(Carbon::now()->format('Y-m-d h:i:s')),
						'timeend' => strtotime(date("Y-m-d 23:59:59", $group->starttime)),
						'groupid' => $group->id
					]);
				}
			}

			//jika tidak ada data yang ingin di push maka langsung berhentikan program
			if (count($enrollements_push) == 0) {
				return response([
					'status' => 'Success',
					'message' => 'Data didaftarkan dalam moodle',
					'response' => null
				], 200);
			}

			//jika ada data maka akan melanjutkan insert moodle enrollment
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_enrol_users';

			//masukkan seluruh data kedalam form param untuk execute moodle
			$index = 0;

			foreach ($enrollements_push as $key => $value) {
				$formParam['enrolments'][$index]['userid'] = $value['userid'];
				$formParam['enrolments'][$index]['courseid'] = $value['courseid'];
				$formParam['enrolments'][$index]['roleid'] = $value['roleid'];
				$formParam['enrolments'][$index]['timestart'] = $value['timestart'];
				$formParam['enrolments'][$index]['timeend'] = $value['timeend'];
				$formParam['enrolments'][$index]['groupid'] = $value['groupid'];

				$index++;
			}

			//execute moodle nya
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			//validasi response nya jika error langsung return tanpa insert ke database
			if ($response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Gagal mendaftarkan data kedalam moodle',
					'error' => $response
				], 500);
			}

			//jika berhasil lakukan insert ke table moodle_enrollment
			foreach ($enrollements_push as $key => $value) {
				Moodle_Enrollments::create([
					'moodle_user_id' => $value['userid'],
					'moodle_course_id' => $value['courseid'],
					'role_id' => $value['roleid'],
					'timestart' => $value['timestart'],
					'timeend' => $value['timeend'],
					'moodle_group_id' => $value['groupid'],
					'json_response' => json_encode($response),
					'created_by' => $by
				]);
			}

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for creating moodle Quiz
	public function InsertMoodleQuiz(Request $req)
	{
		$by = $req->header("X-I");

		//get participant data
		$moodle_course = Moodle_Courses::select(
			'id',
			'enddate'
		)
			->where('id', '=', $req->moodle_course_id)
			->first();

		$moodle_section = Moodle_Sections::select(
			'id',
			'type'
		)
			->where('id', '=', $req->moodle_section_id)
			->first();

		//validate selection path
		if ($moodle_course == null || $moodle_section == null) {
			return response([
				'status' => 'Failed',
				'message' => 'Data tidak terdaftar dalam database'
			], 500);
		}

		$timeopen = date('Y-m-d ' . $req->timeopen . ':00', $moodle_course->enddate);
		$timeclose = date('Y-m-d ' . $req->timeclose . ':00', $moodle_course->enddate);

		try {
			//initialize moodle
			$http = new Client();
			$url = env('CBT_MOODLE_URL');

			$formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
			$formParam['moodlewsrestformat'] = 'json';
			$formParam['wsfunction'] = 'local_trisakti_api_create_quizes';

			$formParam['quizes'][0]['course'] = $moodle_course->id;
			$formParam['quizes'][0]['section'] = $moodle_section->id;
			$formParam['quizes'][0]['name'] = $req->name;
			$formParam['quizes'][0]['description'] = $req->description;
			$formParam['quizes'][0]['timeopen'] = strtotime($timeopen);
			$formParam['quizes'][0]['timeclose'] = strtotime($timeclose);
			$formParam['quizes'][0]['timelimit'] = Carbon::parse(strtotime($timeopen))->diffInSeconds(Carbon::parse(strtotime($timeclose)));
			$formParam['quizes'][0]['attempts'] = 1; // jumlah percobaan ujian
			$formParam['quizes'][0]['attemptclosed'] = 0; //melihat lembar jawaban / review jawaban yang telah disi
			$formParam['quizes'][0]['marksclosed'] = 0; //melihat nilai

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Data sudah pernah didaftarkan dalam moodle',
					'response' => $response
				], 500);
			}

			Moodle_Quizes::create([
				'id' => $response['data'][0]['id'],
				'moodle_course_id' => $formParam['quizes'][0]['course'],
				'moodle_section_id' => $formParam['quizes'][0]['section'],
				'name' => $formParam['quizes'][0]['name'],
				'description' => $formParam['quizes'][0]['description'],
				'timeopen' => $formParam['quizes'][0]['timeopen'],
				'timeclose' => $formParam['quizes'][0]['timeclose'],
				'timelimit' => $formParam['quizes'][0]['timelimit'],
				'attempts' => $formParam['quizes'][0]['attempts'],
				'attempt_closed' => $formParam['quizes'][0]['attemptclosed'],
				'mark_closed' => $formParam['quizes'][0]['marksclosed'],
				'json_response' => json_encode($response),
				'created_by' => $by,
				'type' => $moodle_section->type //for type sessi (1,2,3)
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data didaftarkan dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal mendaftarkan data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertDocumentTranscript(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$datas = json_decode($req->json, true);

			$document = Document::create([
				'document_type_id' => $datas['document_type_id'],
				'name' => $datas['document_name'],
				'description' => $datas['document_description'],
				'created_by' => $by,
				'url' => ($req->file('url') == null) ? null : env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant')
			]);

			$document_transcript = Document_Transcript::create([
				'document_id' => $document->id,
				'total_credit' => $datas['total_credit'],
				'total_course' => $datas['total_course'],
				'registration_number' => $datas['registration_number'],
				'created_by' => $by
			]);

			foreach ($datas['courses'] as $key => $value) {
				Mapping_Transcript_Participant::create([
					'course_code' => $value['course_code'],
					'course_name' => $value['course_name'],
					'credit_hour' => $value['credit_hour'],
					'grade' => $value['grade'],
					'document_transcript_id' => $document_transcript->id,
					'created_by' => $by
				]);
			}

			DB::connection('pgsql')->commit();

			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {

			DB::connection('pgsql')->rollBack();

			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertIntoDocumentUtbk(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$document = Document::create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'created_by' => $by,
				'url' => env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'approval_final_status' => $req->approval_final_status,
				'approval_final_date' => isset($req->approval_final_status) ? Carbon::now() : null,
				'approval_final_by' => isset($req->approval_final_status) ? $by : null,
				'approval_final_comment' => $req->approval_final_comment
			]);

			$utbk = Document_Utbk::create(
				[
					'document_id' => $document->id,
					'created_by' => $by,
					'mapel1' => $req->mapel1,
					'mapel2' => $req->mapel2,
					'mapel3' => $req->mapel3,
					'mapel4' => $req->mapel4,
					'mapel5' => $req->mapel5,
					'mapel6' => $req->mapel6,
					'mapel7' => $req->mapel7,
					'mapel8' => $req->mapel8,
					'mapel9' => $req->mapel9,
					'mapel10' => $req->mapel10,
					'registration_number' => $req->registration_number,
					'general_reasoning' => $req->general_reasoning,
					'quantitative_knowledge' => $req->quantitative_knowledge,
					'comprehension_general_knowledge' => $req->comprehension_general_knowledge,
					'comprehension_reading_knowledge' => $req->comprehension_reading_knowledge,
					'major_type' => $req->major_type
				]
			);

			return response([
				'status' => 'Success',
				'utbk_id' => $utbk->id,
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	//api for creating document publication
	public function InsertIntoDocumentPublication(Request $req)
	{
		try {
			//validate size file if size > 2 mb break program
			$validate = Validator::make($req->all(), [
				'url' => 'file|max:2100'
			]);

			if ($validate->fails()) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, ukuran file harus lebih kecil dari 2 Mb'
				], 500);
			}

			$by = $req->header("X-I");

			$document = Document::create([
				'document_type_id' => $req->document_type_id,
				'name' => $req->name,
				'description' => $req->description,
				'number' => $req->number,
				'url' => ($req->file == null) ? null : env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant'),
				'created_by' => $by
			]);

			Document_Publication::create(
				[
					'document_id' => $document->id,
					'writer_name' => $req->writer_name,
					'publication_writer_position_id' => $req->publication_writer_position_id,
					'title' => $req->title,
					'publication_type_id' => $req->publication_type_id,
					'publish_date' => $req->publish_date,
					'publication_link' => $req->publication_link,
					'created_by' => $by,
					'participant_id' => $req->participant_id
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingNewStudentStep(Request $req)
	{
		try {
			Mapping_New_Student_Step::updateOrCreate(
				[
					'new_student_id' => $req->new_student_id,
					'new_student_step_id' => $req->new_student_step_id
				],
				[
					'new_student_id' => $req->new_student_id,
					'new_student_step_id' => $req->new_student_step_id
				]
			);

			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	//api for creating new student
	function CreateOrUpdateNewStudent($registration_number, $participant_id, $program_study_id, $by)
	{
		try {
			New_Student::updateOrCreate(
				[
					'registration_number' => $registration_number,
				],
				[
					'registration_number' => $registration_number,
					'participant_id' => $participant_id,
					'program_study_id' => $program_study_id,
					'created_by' => $by
				]
			);

			//ketika admin insert new student maka akan menambahkan satu role baru di framework user
			$participant = Participant::find($participant_id);
			$user = Framework_User::select('*')->where('username', '=', $participant->username)->first();

			Framework_Mapping_User_Role::updateOrCreate(
				[
					'user_id' => $user->id,
					'oauth_role_id' => env('NEW_STUDENT_OAUTH_ID'),
				],
				[
					'user_id' => $user->id,
					'oauth_role_id' => env('NEW_STUDENT_OAUTH_ID'),
					'created_by' => $by
				]
			);

			return true;
		} catch (\Throwable $th) {
			return false;
		}
	}

	public function InsertStudentIdAndEmailNewStudent(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$new_student = New_Student::find($req->id);

			if ($new_student == null) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, data gagal disimpan',
					'error' => 'New Student not recorded in database'
				], 500);
			}

			if ($new_student->email != null) {
				return response([
					'status' => 'Success',
					'message' => 'Data Tersimpan'
				], 200);
			}

			$student_id = $this->GenerateStudentIdNumber($new_student->registration_number, $new_student->program_study_id);
			$email = $student_id . "@trisakti.ac.id";

			New_Student::find($new_student->id)->update([
				'email' => $email,
				'student_id' => $student_id,
				'updated_by' => $by
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	//api for creating new student
	public function InsertIntoNewStudent(Request $req)
	{
		$by = $req->header("X-I");

		try {
			//insert data ke table new student
			New_Student::create([
				'registration_number' => $req->registration_number,
				'participant_id' => $req->participant_id,
				'program_study_id' => $req->program_study_id,
				'student_id' => $this->GenerateStudentIdNumber($req->registration_number, $req->program_study_id),
				'created_by' => $by
			]);

			//ketika admin insert new student maka akan menambahkan satu role baru di framework user
			$participant = Participant::find($req->participant_id);
			$user = Framework_User::select('*')->where('username', '=', $participant->username)->first();

			Framework_Mapping_User_Role::updateOrCreate(
				[
					'user_id' => $user->id,
					'oauth_role_id' => env('NEW_STUDENT_OAUTH_ID'),
				],
				[
					'user_id' => $user->id,
					'oauth_role_id' => env('NEW_STUDENT_OAUTH_ID'),
					'created_by' => $by
				]
			);

			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	public function CreateOrUpdateMappingNewStudentDocumentType(Request $req)
	{
		try {
			Mapping_New_Student_Document_Type::updateOrCreate(
				[
					'selection_path_id' => $req->selection_path_id,
					'study_program_id' => $req->study_program_id,
					'new_student_document_type_id' => $req->new_student_document_type_id
				],
				[
					'selection_path_id' => $req->selection_path_id,
					'faculty_id' => $req->faculty_id,
					'study_program_id' => $req->study_program_id,
					'new_student_document_type_id' => $req->new_student_document_type_id
				]
			);
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	function updateMappingNewStudentDocumentType($selection_path_id, $study_program_id, $new_student_document_type_id)
	{
		Mapping_New_Student_Document_Type::updateOrCreate(
			[
				'selection_path_id' => $selection_path_id,
				'study_program_id' => $study_program_id,
				'new_student_document_type_id' => $new_student_document_type_id
			],
			[
				'selection_path_id' => $selection_path_id,
				'study_program_id' => $study_program_id,
				'new_student_document_type_id' => $new_student_document_type_id
			]
		);
	}

	//private function for generating student id
	function GenerateStudentIdNumber($registration_number, $program_study_id)
	{
		$data = Registration_Result::select(
			'registration_result.*',
			'r.mapping_path_year_intake_id',
			'mpyi.year',
			'mpyi.semester',
			'sps.specialization_code',
			'sps.class_type_id'
		)
			->join('registrations as r', 'registration_result.registration_number', '=', 'r.registration_number')
			->join('mapping_path_year_intake as mpyi', 'r.mapping_path_year_intake_id', '=', 'mpyi.id')
			->join('mapping_registration_program_study as mrps', function ($join) {
				$join->on('registration_result.registration_number', '=', 'mrps.registration_number')
					->on('registration_result.program_study_id', '=', 'mrps.program_study_id');
			})
			->join('study_program_specializations as sps', 'mrps.study_program_specialization_id', '=', 'sps.id')
			->where('registration_result.registration_number', '=', $registration_number)
			->where('registration_result.program_study_id', '=', $program_study_id)
			->where('registration_result.pass_status', '=', true)
			->first();

		if ($data == null) {
			return null;
		}

		/*
			Kode Prodi ada yang 3 / 4 / 5 digit. Untuk prodi yang hanya
			ada 3 atau 4 digit, sisanya diganti dengan angka 0
			*/
		$program_study = str_pad($data->program_study_id, 5, '0', STR_PAD_LEFT);

		/*
			Tahun ajaran masuk
			2021 -> 21
			2022 -> 22
			2023 -> 23 dst.
			*/
		$school_year = substr(explode("/", $data->year)[0], 2, 3);

		/*
			Semester masuk
			0 : semester ganjil
			1 : semester genap
			*/
		$semester = ($data->semester == 1) ? 0 : 1;

		/*
			Kode kampus
			Ex: kampus sentu
			*/
		$campus_code = $data->specialization_code;

		/*
			Kode kelas
			Ex: 5 kelas khusus
			0 kelas reguler
			*/
		$class_code = $data->class_type_id;

		/*
			tmp gabungan dari program study, tahun ajar, semester, kode kampus dan kode kelas
			untuk mencari increment
			*/
		$tmp = $program_study . $school_year . $semester . $campus_code . $class_code;

		/*
			Nomor urut
			*/
		$increment = New_Student::select('new_student.id')
			->where('new_student.student_id', 'LIKE', "$tmp%")
			->get()
			->count();

		$increment = str_pad($increment + 1, 2, '0', STR_PAD_LEFT);

		//result
		$student_id = $tmp . $increment;
		return $student_id;
	}

	function GenerateFormulirTrxId($registration_number)
	{
		$client_id = env('CLIENT_ID'); //client id from BNI
		$prefix = env('PREFIX'); //prefix id from BNI
		$tmp = $prefix . $client_id . $registration_number . 0; //tmp gabungan dari client id dan prefix;

		/*
			Nomor urut
			*/
		$increment = Transaction_Request::select('id')
			->get()
			->count();

		$increment = str_pad($increment + 1, 3, '0', STR_PAD_LEFT);

		//result
		$student_id = $tmp . $increment;
		return $student_id;
	}

	function GenerateFinalTrxId($registration_number)
	{
		$client_id = env('CLIENT_ID'); //client id from BNI
		$prefix = env('PREFIX'); //prefix id from BNI
		$tmp = $prefix . $client_id . $registration_number . '1'; //tmp gabungan dari client id dan prefix;

		/*
			Nomor urut
			*/
		$increment = Transaction_Billing::select('id')
			->get()
			->count();

		$increment = str_pad($increment + 1, 3, '0', STR_PAD_LEFT);

		//result
		$student_id = $tmp . $increment;
		return $student_id;
	}

	//function for generating biiling for new student
	public function CreateBillingNewStudent(Request $req)
	{
		try {
			//validate parameters
			$validate = Validator::make($req->all(), [
				'registration_number' => 'required',
				'token' => 'required'
			]);

			//throw exception if parameter not required
			if ($validate->fails()) {
				throw new Exception("Parameter required");
			}

			//call create billing api
			$http = new Client(['verify' => false]);
			$url = env('URL_BILLING_TRANSACTION');

			//get registration
			$registration = Registration_Result::select(
				'registration_result.registration_number',
				DB::raw("substring(mpyi.year from 1 for 4) as year"),
				'registration_result.semester',
				'registration_result.program_study_id',
				'registration_result.specialization_id',
				'sps.class_type_id',
				DB::raw("case when registration_result.rank is null then 0 else registration_result.rank end as rank"),
				'p.fullname',
				'p.username',
				'p.mobile_phone_number',
				'tb.id as transaction_billing_id'
			)
				->join('registrations as r', 'registration_result.registration_number', '=', 'r.registration_number')
				->join('participants as p', 'r.participant_id', '=', 'p.id')
				->join('mapping_path_year_intake as mpyi', 'r.mapping_path_year_intake_id', '=', 'mpyi.id')
				->leftJoin('study_program_specializations as sps', 'registration_result.specialization_id', '=', 'sps.id')
				->leftJoin('transaction_billings as tb', 'registration_result.registration_number', '=', 'tb.registration_number')
				->where('registration_result.registration_number', '=', $req->registration_number)
				->first();

			//validate registration
			if ($registration == null) {
				throw new Exception("Registration result not found");
			}

			//validate transaction billing agar tidak di execute berulang kali
			//jika transaction biiling nya tidak null maka langsung return
			if ($registration->transaction_billing_id != null) {
				return response()->json([
					'status' => 'Success',
					'message' => 'Billing has been generated'
				], 200);
			}

			//put param
			$param = [
				'registration_number' => $registration->registration_number,
				'school_year' => $registration->year,
				'semester' => $registration->semester,
				'study_program_id' => $registration->program_study_id,
				'specialization_id' => $registration->specialization_id,
				'class_type_id' => $registration->class_type_id,
				'spp_rank_id' => $registration->rank,
				'email' => $registration->username,
				'fullname' => $registration->fullname,
				'mobile_phone_number' => $registration->mobile_phone_number
			];

			// $request = $http->post($url, [
			// 	'form_params' => $param,
			// 	'headers' => [
			// 		'Authorization' => 'Bearer ' . $req->token
			// 	]
			// ]);

			// //validate code request
			// if ($request->getStatusCode() != 200) {
			// 	throw new Exception("Error while executing billing");
			// }

			// //get response
			// $response = json_decode($request->getBody(), true);

			// //validate response
			// if ($response['status'] != "success") {
			// 	throw new Exception("Status billing failed");
			// }

			//add another data in param variable for inserting into admission db
			// $param['total_cost'] = $response['total_cost'];
			// $param['start_date_payment'] = $response['start_date_payment'];
			// $param['end_date_payment'] = $response['end_date_payment'];
			// $param['virtual_account'] = $response['status_create_va']['original']['response']['virtual_account'];
			// $param['trx_id'] = $response['status_create_va']['original']['response']['trx_id'];
			// $param['json_response'] = json_encode($response);
			$param['created_by'] = $req->header('X-I');

			//put param variable while insert or update data to transaction billings table
			Transaction_Billing::updateOrCreate(['registration_number' => $req->registration_number], $param);

			return response()->json([
				'status' => 'Success',
				'message' => 'Success generating new billing'
			], 200);
		} catch (\Throwable $th) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Error generating new billing',
				'error' => $th->getMessage()
			], 500);
		}
	}

	public function InsertExamType(Request $req)
	{
		try {
			DB::connection('pgsql')->beginTransaction();

			\Log::info('Request data: ', $req->all()); // Tambahkan log untuk melihat input JSON

			Exam_Type::create([
				'name' => $req->name,
				'active_status' => $req->active_status,
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertCategory(Request $req)
	{
		try {
			Category::create([
				'name' => $req->name,
				'status' => $req->status,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertSelectionCategory(Request $req)
	{
		try {
			DB::connection('pgsql')->beginTransaction();

			\Log::info('Request data: ', $req->all()); // Tambahkan log untuk melihat input JSON

			Selection_Category::create([
				'name' => $req->name,
				'description' => $req->description,
				'active_status' => $req->active_status,
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertForms(Request $req)
	{
		try {
			Form::create([
				'name' => $req->name,
				'status' => $req->status,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertSchedule(Request $req)
	{
		try {
			Schedule::create([
				'selection_path_id' => $req->selection_path_id,
				'category_id' => $req->category_id,
				'session' => $req->session,
				'date' => $req->date,
				'status' => $req->status,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertDocumentCategories(Request $req)
	{
		try {
			Document_Categories::create([
				'name' => $req->name,
				'status' => $req->status,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertStudentInterest(Request $req)
	{
		try {
			Education_Major::create([
				'major' => $req->major,
				'education_degree_id' => $req->education_degree_id,
				'created_by' => $req->created_by,
				'updated_by' => $req->updated_by,
				'created_at' => $req->created_at,
				'updated_at' => $req->updated_at,
				'is_technic' => $req->is_technic,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertEducationDegree(Request $req)
	{
		// return response()->json($req->all());
		try {
			Education_Degree::create([
				'level' => $req->level,
				'description' => $req->description,
				'created_by' => $req->created_by,
				'updated_by' => $req->updated_by,
				'created_at' => $req->created_at,
				'updated_at' => $req->updated_at,
				'type' => $req->type
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			response()->json();
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertStudyProgram(Request $req)
	{
		try {
			Study_Program::create([
				'classification_id' => $req->classification_id,
				'program_study_id' => $req->program_study_id,
				'faculty_id' => $req->faculty_id,
				'category' => $req->category,
				'classification_name' => $req->classification_name,
				'study_program_branding_name' => $req->study_program_branding_name,
				'study_program_name' => $req->study_program_name,
				'study_program_name_en' => $req->study_program_name_en,
				'study_program_acronim' => $req->study_program_acronim,
				'faculty_name' => $req->faculty_name,
				'acronim' => $req->acronim,
				'acreditation' => $req->acreditation,
				'quota' => $req->quota,
				'sks' => $req->sks
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			response()->json();
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiCategory(Request $req)
	{
		try {
			$datas = json_decode($req->json, true);
			Mapping_Prodi_Category::where('prodi_fk', $datas['prodi'])->delete();
			$prodi = Study_Program::where('classification_id', $datas['prodi'])->first();
			\Log::info('Request data: ', $req->all()); // Tambahkan log untuk melihat input JSON

			foreach ($datas['terpilih'] as $key => $select) {
				Mapping_Prodi_Category::create([
					'prodi_fk' => $prodi->classification_id,
					'nama_prodi' => $prodi->study_program_branding_name,
					'dokumen_fk' => $select['dokumen_id'],
					'nama_dokumen' => $select['nama_dokumen'],
					'selectedstatus' => $select['sifatdokumen'],
				]);
			}

			$data = Mapping_Prodi_Category::where('prodi_fk', $datas['prodi'])->first();

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
				'data' => $data
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiFormulir(Request $req)
	{
		try {
			Mapping_Prodi_Formulir::create([
				'prodi_fk' => $req->prodi_fk,
				'nama_prodi' => $req->nama_prodi,
				'nama_formulir' => $req->nama_formulir,
				'harga' => $req->harga,
				'add_cost' => $req->add_cost,
				'exam_status' => $req->exam_status,
				'kategori_formulir' => $req->kategori_formulir,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiBiaya(Request $req)
	{
		try {
			Mapping_Prodi_Biaya::create([
				'prodi_fk' => $req->prodi_fk,
				'nama_prodi' => $req->nama_prodi,
				'kelas_fk' => $req->kelas_fk,
				'nama_kelas' => $req->nama_kelas,
				'spp_i' => $req->spp_i,
				'spp_ii' => $req->spp_ii,
				'spp_iii' => $req->spp_iii,
				'praktikum' => $req->praktikum,
				'bpp_pokok' => $req->bpp_pokok,
				'bpp_sks' => $req->bpp_sks,
				'bpp_i' => $req->bpp_i,
				'bpp_ii' => $req->bpp_ii,
				'bpp_iii' => $req->bpp_iii,
				'biaya_ujian' => $req->biaya_ujian,
				'add_foreign' => $req->add_foreign,
				'biaya_lainnya' => $req->biaya_lainnya
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMasterMataPelajaran(Request $req)
	{
		try {
			Master_Matpel::create([
				'name' => $req->name,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertStudyProgramSpecialization(Request $req)
	{
		if ($req->class_type_id) {
			$class_id = $req->class_type_id;
			$class = $req->class_type;
		} else {
			$data = Study_Program_Specialization::select(
				'class_type',
				'class_type_id as id'
			)
				->where('study_program_specializations.active_status', '=', true)
				->distinct()->get()->count();
			$class_id = $data + 1;
			$class = $req->class_type;
		}

		try {
			Study_Program_Specialization::create([
				'specialization_name' => $req->specialization_name,
				'specialization_code' => $req->specialization_code,
				'active_status' => $req->active_status,
				'class_type' => $class,
				'class_type_id' => $class_id,
				'classification_id' => $req->classification_id,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			\Log::error('Error: ', ['exception' => $e->getMessage()]); // Tambahkan log untuk kesalahan
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertFaculty(Request $req)
	{
		try {
			Study_Program::create([
				'program_study_id' => $req->program_study_id,
				'faculty_id' => $req->faculty_id,
				'category' => $req->category,
				'classification_name' => $req->classification_name,
				'study_program_branding_name' => $req->study_program_branding_name,
				'study_program_name' => $req->study_program_name,
				'study_program_name_en' => $req->study_program_name_en,
				'study_program_acronim' => $req->study_program_acronim,
				'faculty_name' => $req->faculty_name,
				'acronim' => $req->acronim,
				'acreditation' => $req->acreditation,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertDocumentType(Request $req)
	{
		try {
			$type = Document_Type::create([
				'name' => $req->name,
				'description' => $req->description,
			]);

			New_Student_Document_Type::create(
				[
					'document_type_id' => $type->id,
					'name' => $req->name,
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiMatapelajaran(Request $req)
	{
		try {
			$datas = json_decode($req->json, true);
			$pelajarans = [];
			$prodi = Study_Program::where('classification_id', $datas['prodi'])->first();
			$mapping_matapelajaran = Mapping_Prodi_Matapelajaran::where('prodi_id', $datas['prodi'])->count();
			if ($mapping_matapelajaran > 0) {
				Mapping_Prodi_Matapelajaran::where('prodi_id', $datas['prodi'])->delete();
			}
			for ($i = 0; $i < count($datas['terpilih']); $i++) {
				$matpel = Master_Matpel::where('id', $datas['terpilih'][$i])->first();
				array_push($pelajarans, [
					'fakultas' => $prodi->faculty_name,
					'fakultas_id' => $prodi->faculty_id,
					'prodi_id' => $prodi->classification_id,
					'nama_prodi' => $prodi->study_program_branding_name,
					'mata_pelajaran' => $matpel->name,
					'pelajaran_id' => $matpel->id,
					'status' => true
				]);
			}
			Mapping_Prodi_Matapelajaran::insert($pelajarans);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiMinat(Request $req)
	{
		try {
			$datas = json_decode($req->json, true);
			$minats = [];
			$prodi = Study_Program::where('classification_id', $datas['prodi'])->first();
			$mapping_minat = Mapping_Prodi_Minat::where('prodi_id', $datas['prodi'])->count();
			if ($mapping_minat > 0) {
				Mapping_Prodi_Minat::where('prodi_id', $datas['prodi'])->delete();
			}
			for ($i = 0; $i < count($datas['terpilih']); $i++) {
				$minat = Education_Major::where('id', $datas['terpilih'][$i])->first();
				array_push($minats, [
					'fakultas' => $prodi->faculty_name,
					'fakultas_id' => $prodi->faculty_id,
					'prodi_id' => $prodi->classification_id,
					'nama_prodi' => $prodi->study_program_branding_name,
					'nama_minat' => $minat->major,
					'minat_id' => $minat->id,
					'quota' => 0,
					'status' => true
				]);
			}
			Mapping_Prodi_Minat::insert($minats);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertPackageQuestionUsers(Request $req)
	{
		try {
			DB::connection('pgsql')->beginTransaction();
			$ujian = Mapping_Prodi_Ujian::where('study_program_id', $req->study_program_id)->get();
			if (!$ujian) {
				return response()->json([
					'message' => 'Mapping ujian not found.'
				], 400);
			}
			foreach ($ujian as $key => $value) {
				$ped = Path_Exam_Detail::where(['exam_type_id' => $value->exam_type_id, 'class_type' => $req->class_type, 'active_status' => 'true', 'selection_path_id' => $req->selection_path_id])->whereDate('exam_start_date', '=', Carbon::parse($req->date_exam)->format('Y-m-d'))->first();
				$package = CBT_Package_Questions::where('type_id', $value->exam_type_id)->inRandomOrder()->first();
				if ($package && $ped) {
					CBT_Package_Question_Users::create([
						'package_question_id' => $package->id,
						'user_id' => $req->user_id,
						'classes' => $req->class_type,
						'registration_number' => $req->registration_number,
						'date_exam' => Carbon::parse($req->date_exam)->format('Y-m-d'),
						'date_start' => ($req->class_type == "Reguler") ? Carbon::parse($req->date_exam . $ped->session_one_start)->format('Y-m-d H:i:s') : $ped->exam_start_date,
						'date_end' => ($req->class_type == "Reguler") ? Carbon::parse($req->date_exam . $ped->session_one_end)->format('Y-m-d H:i:s') : $ped->exam_end_date,
						'status' => true
					]);
				}
			}

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMappingProdiUjian(Request $req)
	{
		try {
			$datas = json_decode($req->json, true);
			$exams = [];
			$prodi = Study_Program::where('classification_id', $datas['prodi'])->first();
			$ujian = Mapping_Prodi_Ujian::where('study_program_id', $datas['prodi'])->count();
			if ($ujian > 0) {
				Mapping_Prodi_Ujian::where('study_program_id', $datas['prodi'])->delete();
			}
			for ($i = 0; $i < count($datas['terpilih']); $i++) {
				$exam = Exam_Type::where('id', $datas['terpilih'][$i])->first();
				array_push($exams, [
					'study_program_id' => $prodi->classification_id,
					'exam_type_id' => $exam->id,
					'status' => true
				]);
			}
			Mapping_Prodi_Ujian::insert($exams);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertTransferCredit(Request $req)
	{
		try {
			Transfer_Credit::create([
				'participant_id' => $req->participant_id,
				'kode_matakuliah_ex' => $req->kode_matakuliah_ex,
				'nama_matakuliah_ex' => $req->nama_matakuliah_ex,
				'sks_ex' => $req->sks_ex,
				'nilai_ex' => $req->nilai_ex,
				'kode_matakuliah' => $req->kode_matakuliah,
				'nama_matakuliah' => $req->nama_matakuliah,
				'sks' => $req->sks,
				'nilai' => $req->nilai
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function InsertMasterPackage(Request $req)
	{
		try {
			DB::connection('pgsql')->beginTransaction();
			$datas = json_decode($req->json);
			$paket = Master_Package::create([
				'nama_paket'  	=> json_decode($req->nama_paket),
				'angsuran' 		=> $req->angsuran,
				'study_program_id' => $req->study_program_id,
			]);
			\Log::info('Request data: ', $req->all()); // Tambahkan log untuk melihat input JSON

			foreach ($datas->angsuran as $key => $item) {
				Master_Package_Angsuran::create([
					'package_id' => $paket->id,
					'angsuran_ke' =>  $item->angsuran_ke,
					'spp' => $item->spp,
					'bpp'  => $item->bpp,
					'bpp_sks'  => $item->bpp_sks,
					'praktikum' => $item->praktikum,
					'ujian' => $item->ujian,
					'lainnya' => $item->lainnya,
					'disc' => $item->disc,
					'disc_spp' => $item->disc_spp,
					'disc_bpp' => $item->disc_bpp,
					'disc_bpp_sks' => $item->disc_bpp_sks,
					'disc_praktikum' => $item->disc_praktikum,
					'disc_lainnya' => $item->disc_lainnya,
				]);
			}

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan',
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function RequestPinTransactionResult(Request $req)
	{
		$by = $req->header("X-I");
		$ipfy = '';
		$createVA = '';
		$datajson = '';
		$request_body = '';
		try {
			$client_id = env('CLIENT_ID'); //client id from BNI
			$prefix = env('PREFIX'); //prefix id from BNI
			$secret_key = env('SECRET_VA'); // secret key from BNI
			$registration = Registration_Result::select(
				'registration_result.registration_number',
				DB::raw("substring(mpyi.year from 1 for 4) as year"),
				'registration_result.semester',
				'registration_result.program_study_id',
				'registration_result.specialization_id',
				'registration_result.end_date_1',
				'sps.class_type_id',
				DB::raw("case when registration_result.rank is null then 0 else registration_result.rank end as rank"),
				'p.fullname',
				'p.username',
				'p.mobile_phone_number',
				'tb.id as transaction_billing_id'
			)
				->join('registrations as r', 'registration_result.registration_number', '=', 'r.registration_number')
				->join('participants as p', 'r.participant_id', '=', 'p.id')
				->join('mapping_path_year_intake as mpyi', 'r.mapping_path_year_intake_id', '=', 'mpyi.id')
				->join('study_program_specializations as sps', 'registration_result.specialization_id', '=', 'sps.id')
				->leftJoin('transaction_billings as tb', 'registration_result.registration_number', '=', 'tb.registration_number')
				->where('registration_result.registration_number', '=', $req->registration_number)
				->first();

			//validate registration
			if ($registration == null) {
				return response()->json([
					'status' => 'Failed',
					'message' => 'Registration result not found',
				], 400);
			}

			//validate transaction billing agar tidak di execute berulang kali
			//jika transaction biiling nya tidak null maka langsung return
			if ($registration->virtual_account != null) {
				return response()->json([
					'status' => 'Success',
					'message' => 'Billing has been generated'
				], 200);
			}


			$trx_id = $this->GenerateFinalTrxId($req->registration_number);
			$number = str_pad($req->registration_number, 11, '0', STR_PAD_LEFT);
			$va   = $prefix . $client_id . "2" . $number;
			// $trx_id = strtotime("now") . $client_id . $req->registration_number;
			$request_body = array(
				"type"              => 'createbilling',
				"client_id"         => $client_id,
				"trx_id"            => $trx_id,
				"trx_amount"        => $req->amount,
				"billing_type"		=> "c",
				"customer_name"     => $req->participant_name,
				"customer_email"    => $req->participant_email,
				"customer_phone"    => $req->participant_phone_number,
				"virtual_account"   => $va,
				"datetime_expired"  => Carbon::now()->addWeek(1)->format('Y-m-d h:i:s'),
				"description"       => $req->add_info1,
			);

			$hashdata = BniEnc::encrypt($request_body, $client_id, $secret_key);
			$datajson = json_encode(array(
				'client_id' => $client_id,
				'prefix' => $prefix,
				'data' => $hashdata,
			));

			$http = new Client(['verify' => false]);

			$request = $http->post(env('URL_CREATE_TRANSACTION_VA'), [
				'body' => $datajson,
				'headers' => [
					'Content-Type' => 'application/json',
					'Origin' => 'String',
				],
				'connect_timeout' => 25
			]);

			$createVA = json_decode($request->getBody(), true);

			if (isset($createVA['data']) && $req->amount > 0) {
				$parsedata = BniEnc::decrypt($createVA['data'], $client_id, $secret_key);

				$dataToSend['va_number'] = $req->registration_number;
				$dataToSend['trx_amount'] = $req->amount;
				$dataToSend['customer_name'] = $req->participant_name;
				$dataToSend['customer_email'] = $req->participant_email;
				$dataToSend['customer_phone'] = $req->participant_phone_number;
				$dataToSend['datetime_expired'] = Carbon::now()->addWeek(24)->format('Y-m-d h:i:s');
				$dataToSend['description'] = $req->add_info1;
				//put param
				$param = [
					'registration_number' => $registration->registration_number,
					'school_year' => $registration->year,
					'semester' => $registration->semester,
					'study_program_id' => $registration->program_study_id,
					'specialization_id' => $registration->specialization_id,
					'class_type_id' => $registration->class_type_id,
					'spp_rank_id' => $registration->rank,
					'email' => $registration->username,
					'fullname' => $registration->fullname,
					'total_cost' => $req->amount,
					'mobile_phone_number' => $registration->mobile_phone_number,
					'virtual_account' => $parsedata['virtual_account'],
					'trx_id' => $parsedata['trx_id'],
					'json_response' => $parsedata,
				];

				$param['created_by'] = $req->header('X-I');

				//put param variable while insert or update data to transaction billings table
				Transaction_Billing::updateOrCreate(['registration_number' => $req->registration_number], $param);

				$email = $req->participant_email;
				$name = $req->participant_name;

				$data = [
					'virtual_account' => $parsedata['virtual_account'],
					'expiredat' => $registration->end_date_1,
					'noreg' => $req->registration_number,
				];

				Mail::send('virtual_account_mail', $data, function ($message) use ($email, $name) {
					$message->to($email, $name)->subject('Trisakti University Admission');
				});

				return response()->json([
					'status' => 'Success',
					'message' => 'Berhasil membuat VA',
					'result' => $parsedata
				], 200);
			} else {
				// return response()->json([
				// 	'status' => 'Success',
				// 	'message' => 'Berhasil membuat VA',
				// 	'response' => $createVA
				// ], 200);
				return response()->json([
					'status' => 'Failed',
					'message' => 'Gagal membuat VA / Tidak Menemukan Tagihan!',
					'response' => $createVA
				], 400);
			}
		} catch (\Throwable $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'result' => $e->getMessage()
			], 500);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'result' => $e->getMessage()
			], 500);
		} catch (\GuzzleHttp\Exception\BadResponseException $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Transaction Failed',
				'result' => $e->getMessage()
			], 500);
		}
		return response()->json([
			'status' => 'Success',
			'request_body' => $request_body,
			'result' => $createVA
		], 200);
	}

	public function BodyEncrypt(Request $req)
	{
		$client_id = 19224; //client id from BNI
		$prefix = 988; //prefix id from BNI
		$secret_key = '7b5a74969ddeadff9e298eb08b9527dc'; // secret key from BNI
		$request_body = array(
			"cumulative_payment_amount" => $req->cumulative_payment_amount,
			"customer_name" => $req->customer_name,
			"datetime_payment" => $req->datetime_payment,
			"datetime_payment_iso8601" => $req->datetime_payment_iso8601,
			"payment_amount" => $req->payment_amount,
			"payment_ntb" => $req->payment_ntb,
			"trx_amount" => $req->trx_amount,
			"trx_id" => $req->trx_id,
			"virtual_account" => $req->virtual_account
		);
		$hash = BniEnc::encrypt($request_body, $client_id, $secret_key);
		return response()->json([
			"client_id" => $client_id,
			"data" => $hash
		]);
	}

	public function CreateOrUpdateDiskonKhusus(Request $req) //update kelulusan
	{
		$diskon_khusus = Diskon_Khusus::select('*')
			->where('registration_number', '=', $req->registration_number)
			->first();

		try {
			$by = $req->header("X-I");
			Diskon_Khusus::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'type' => (isset($req->type) != null) ? $req->type : $diskon_khusus->type ?? '',
					'status' => (isset($req->status) != null) ? $req->status : $diskon_khusus->status ?? '',
					'kode_voucher' => (isset($req->kode_voucher) != null) ? $req->kode_voucher : $diskon_khusus->kode_voucher ?? '',
					'approved_by' => $by,
					'approved_at' => (isset($diskon_khusus->approved_at)) ?  $diskon_khusus->approved_at : Carbon::now(),
					'document_url' => ($req->file('document_url') != null) ? env('FTP_URL') . $req->file('document_url')->store('DEV/ADM/Selection/participant/diskon_khusus') : $diskon_khusus->document_url ?? '',
				]
			);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}
}
