<?php

namespace app\Http\Controllers\ADM\StudentAdmission;

use App\Http\Controllers\ADM\StudentAdmission\BniEnc;
use App\Http\Controllers\Controller;
use App\Http\Models\ADM\StudentAdmission\Announcement_Registration_Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use DB;
use Carbon\Carbon;

use App\Http\Models\ADM\StudentAdmission\Framework_Mapping_User_Role;
use App\Http\Models\ADM\StudentAdmission\Framework_User;
use App\Http\Models\ADM\StudentAdmission\Participant;
use App\Http\Models\ADM\StudentAdmission\Selection_Programs;
use App\Http\Models\ADM\StudentAdmission\Location_Exam;
use App\Http\Models\ADM\StudentAdmission\Selection_Path;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Program;
use App\Http\Models\ADM\StudentAdmission\Transaction_Request;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Document;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Step_upt;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Study_Program;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Price;
use App\Http\Models\ADM\StudentAdmission\Path_Exam_Detail;
use App\Http\Models\ADM\StudentAdmission\Mapping_Location_Selection;
use App\Http\Models\ADM\StudentAdmission\Participant_Education;
use App\Http\Models\ADM\StudentAdmission\Participant_Family;
use App\Http\Models\ADM\StudentAdmission\Registration;
use App\Http\Models\ADM\StudentAdmission\Document;
use App\Http\Models\ADM\StudentAdmission\Questionare;
use App\Http\Models\ADM\StudentAdmission\Question;
use App\Http\Models\ADM\StudentAdmission\Answer_Option;
use App\Http\Models\ADM\StudentAdmission\Participant_Work_Data;
use App\Http\Models\ADM\StudentAdmission\Mapping_Registration_Program_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Supporting;
use App\Http\Models\ADM\StudentAdmission\Document_Report_Card;
use App\Http\Models\ADM\StudentAdmission\Document_Certificate;
use App\Http\Models\ADM\StudentAdmission\Document_Recomendation;
use App\Http\Models\ADM\StudentAdmission\Document_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Utbk;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year_Intake;
use App\Http\Models\ADM\StudentAdmission\Mapping_Report_Subject_Path;
use App\Http\Models\ADM\StudentAdmission\Mapping_Utbk_Path;
use App\Http\Models\ADM\StudentAdmission\Moodle_Courses;
use App\Http\Models\ADM\StudentAdmission\Moodle_Users;
use App\Http\Models\ADM\StudentAdmission\Participant_Grade;
use App\Http\Models\ADM\StudentAdmission\Passing_Grade;
use App\Http\Models\ADM\StudentAdmission\Payment_Method;
use App\Http\Models\ADM\StudentAdmission\Pin_Voucher;
use App\Http\Models\ADM\StudentAdmission\Registration_Result;
use App\Http\Models\ADM\StudentAdmission\Study_Program;
use App\Http\Models\ADM\StudentAdmission\Document_Publication;
use App\Http\Models\ADM\StudentAdmission\Document_Transcript;
use App\Http\Models\ADM\StudentAdmission\Exam_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_Transcript_Participant;
use App\Http\Models\ADM\StudentAdmission\New_Student;
use App\Http\Models\ADM\StudentAdmission\Participant_Document;
use App\Http\Models\ADM\StudentAdmission\Selection_Category;
use App\Http\Models\ADM\StudentAdmission\Document_Categories;
use App\Http\Models\ADM\StudentAdmission\Education_Degree;
use App\Http\Models\ADM\StudentAdmission\Selection_Categories;
use App\Http\Models\ADM\StudentAdmission\Student_Interest;
use App\Http\Models\ADM\StudentAdmission\Category;
use App\Http\Models\ADM\StudentAdmission\Education_Major;
use App\Http\Models\ADM\StudentAdmission\Form;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Category;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Formulir;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Biaya;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Matapelajaran;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Minat;
use App\Http\Models\ADM\StudentAdmission\Master_kelas;
use App\Http\Models\ADM\StudentAdmission\Master_Matpel;
use App\Http\Models\ADM\StudentAdmission\Schedule;
use App\Http\Models\ADM\StudentAdmission\Study_Program_Specialization;
use App\Http\Models\ADM\StudentAdmission\Document_Type;
use App\Http\Models\ADM\StudentAdmission\CBT_Package_Question_Users;
use App\Http\Models\ADM\StudentAdmission\Change_Program;
use App\Http\Models\ADM\StudentAdmission\Master_Package;
use App\Http\Models\ADM\StudentAdmission\Master_Package_Angsuran;
use App\Http\Models\ADM\StudentAdmission\New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\Refund_Request;
use App\Http\Models\ADM\StudentAdmission\Transaction_Billing;
use App\Http\Models\ADM\StudentAdmission\Transfer_Credit;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class UpdateController extends Controller
{
	public function UpdatetoSelectionProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Selection_Programs::select('id')->where('id', '=', $req->id)->first();
			$update = Selection_Programs::find($id->id)->update([
				'name' => $req->name,
				'description' => $req->description,
				'active_status' => $req->active_status,
				'updated_by' => $by,
				'category' => $req->category
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil disimpan.',
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan.'
			], 500);
			//return $e;
		}
	}

	//api untuk update jalur seleksi
	public function UpdatetoSelectionPath(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$path = Selection_Path::where('id', '=', $req->id)->first();

			Selection_Path::where('id', '=', $path->id)->update([
				'updated_by' => $by,
				'name' => (isset($_POST['name'])) ? $req->name : $path->name,
				'english_name' => (isset($_POST['english_name'])) ? $req->english_name : $path->english_name,
				'active_status' => (isset($_POST['active_status'])) ? $req->active_status : $path->active_status,
				'maks_program' => (isset($_POST['maks_program'])) ? $req->maks_program : $path->maks_program,
				'exam_status' => (isset($_POST['exam_status'])) ? $req->exam_status : $path->exam_status
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah.',
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function updatetoLocationExam(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Location_Exam::select('id')->where('id', '=', $req->id)->first();
			$update = Location_Exam::find($id->id)->update([
				'city' => $req->city,
				'location' => $req->location,
				'address' => $req->address,
				'active_status' => $req->active_status,
				'updated_by' => $by,
			]);

			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah.'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoExamDetail(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$ped = Path_Exam_Detail::select('*')->where('id', '=', $req->id)->first();

			Path_Exam_Detail::where('id', $ped->id)->update([
				'selection_path_id' => $req->selection_path_id,
				'exam_start_date' => $req->start_date,
				'exam_end_date' => $req->end_date,
				'active_status' => $req->active_status,
				'updated_by' => $by,
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
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoMappingPathStep(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Mapping_Path_Step_upt::select('id')->where('id', '=', $req->id)->first();
			$update = Mapping_Path_Step_upt::find($id->id)->update([
				'selection_path_id' => $req->selection_path_id,
				'registration_step_id' => $req->registration_step_id,
				'ordering' => $req->ordering,
				'active_status' => $req->active_status,
				'updated_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoMappingPathDocument(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$update = Mapping_Path_Document::updateOrCreate(
				[
					'selection_path_id' => $req->selection_path_id,
					'document_type_id' => $req->document_type_id,
					'program_study_id' => $req->program_study_id,
				],
				[
					'active_status' => $req->active_status,
					'updated_by' => $by,
					'required' => $req->required,
					'is_value' => $req->is_value
				]
			);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function UpdatetoMappingPathPrice(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Mapping_Path_Price::select('id')->where('id', '=', $req->id)->first();
			$update = Mapping_Path_Price::where('mpp.id', $id->id)->update([
				'selection_path_id' => $req->selection_path_id,
				'price' => $req->price,
				'maks_study_program' => $req->maks_study_program,
				'active_status' => $req->active_status,
				'updated_by' => $by,
				'mapping_path_year_id' => $req->mapping_path_year_id,
				'category' => $req->category,
				'is_medical' => $req->is_medical
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoMappingPathStudyProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Mapping_Path_Study_Program::select('id')->where('id', '=', $req->id)->first();
			$update = Mapping_Path_Study_Program::where('msp.id', $id->id)->update([
				'selection_path_id' => $req->selection_path_id,
				'program_study_id' => $req->program_study_id,
				'minimum_donation' => $req->minimum_donation,
				'active_status' => $req->active_status,
				'quota' => $req->quota,
				'updated_by' => $by,
				'is_technic' => $req->is_technic
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoParticipant(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$id = Participant::select('id')->where('username', '=', $req->username)->first();

			$data['updated_by'] = $by;

			if ($req->fullname) {
				$data['fullname'] = $req->fullname;
			}
			if ($req->telutizen_status) {
				$data['telutizen_status'] = $req->telutizen_status;
			}
			if ($req->telutizen_student_id) {
				$data['telutizen_student_id'] = $req->telutizen_student_id;
			}
			if ($req->gender) {
				$data['gender'] = $req->gender;
			}
			if ($req->religion) {
				$data['religion'] = $req->religion;
			}
			if ($req->birth_country) {
				$data['birth_country'] = $req->birth_country;
			}
			if ($req->birth_province) {
				$data['birth_province'] = $req->birth_province;
			}
			if ($req->birth_city) {
				$data['birth_city'] = $req->birth_city;
			}
			if ($req->birth_place) {
				$data['birth_place'] = strtoupper($req->birth_place);
			}
			if ($req->birth_date) {
				$data['birth_date'] = Carbon::parse($req->birth_date)->format('Y-m-d');
			}
			if ($req->nationality) {
				$data['nationality'] = $req->nationality;
			}
			if ($req->origin_country) {
				$data['origin_country'] = $req->origin_country;
			}
			if ($req->identify_number) {
				$validate = Validator::make($req->all(), [
					'identify_number' => 'unique:participants,identify_number,' . $id->id
				]);

				if ($validate->fails()) {
					return response([
						'status' => 'Failed',
						'message' => 'Mohon maaf, pendaftaran tidak berhasil. Nomor Identitas Sudah Terdaftar.'
					], 200);
				}

				$data['identify_number'] = $req->identify_number;
				$data['passport_number'] = null;
				$data['passport_expiry_date'] = null;
			}
			if ($req->passport_number) {
				$data['passport_number'] = $req->passport_number;
				$data['identify_number'] = null;
			}
			if ($req->passport_expiry_date) {
				$data['passport_expiry_date'] = $req->passport_expiry_date;
			}
			if ($req->marriage_status) {
				$data['marriage_status'] = $req->marriage_status;
			}
			if ($req->children_total) {
				$data['children_total'] = $req->children_total;
			}
			if ($req->address_country) {
				$data['address_country'] = $req->address_country;
			}
			if ($req->address_province) {
				$data['address_province'] = $req->address_province;
			}
			if ($req->address_city) {
				$data['address_city'] = $req->address_city;
			}
			if ($req->address_disctrict) {
				$data['address_disctrict'] = $req->address_disctrict;
			}
			if ($req->address_detail) {
				$data['address_detail'] = $req->address_detail;
			}
			if ($req->address_postal_code) {
				$data['address_postal_code'] = $req->address_postal_code;
			}
			if ($req->house_phone_number) {
				$data['house_phone_number'] = $req->house_phone_number;
			}
			if ($req->mobile_phone_number) {
				$data['mobile_phone_number'] = $req->mobile_phone_number;
			}
			if ($req->photo_url) {
				//validate size file if size > 2 mb break program
				$validate = Validator::make($req->all(), [
					'photo_url' => 'file|max:2100'
				]);

				if ($validate->fails()) {
					return response([
						'status' => 'Failed',
						'message' => 'Mohon maaf, ukuran photo harus lebih kecil dari 2 Mb'
					], 500);
				}

				$data['photo_url'] = env('FTP_URL') . $req->file('photo_url')->store('DEV/ADM/Selection/participant');
			}
			if ($req->color_blind) {
				$data['color_blind'] = $req->color_blind;
			}
			if ($req->special_needs) {
				$data['special_needs'] = $req->special_needs;
			} else {
				$data['special_needs'] = null;
			}
			if ($req->birth_province_foreign) {
				$data['birth_province_foreign'] = $req->birth_province_foreign;
				$data['birth_province'] = null;
				$data['birth_city'] = null;
			}
			if ($req->birth_city_foreign) {
				$data['birth_city_foreign'] = $req->birth_city_foreign;
				$data['birth_province'] = null;
				$data['birth_city'] = null;
			}
			if ($req->nis) {
				$data['nis'] = $req->nis;
			}
			if ($req->size_almamater) {
				$data['size_almamater'] = $req->size_almamater;
			}

			$update = Participant::find($id->id)->update($data);
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

	public function UpdatetoParticipantEducation(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Participant_Education::select('*')->where('id', '=', $req->id)->first();

			Participant_Education::find($id->id)->update([
				'education_degree_id' => $req->education_degree_id,
				'education_major_id' => $req->education_major_id,
				'school_id' => $req->school_id,
				'graduate_year' => $req->graduate_year,
				'student_id' => $req->student_id,
				'last_score' => $req->last_score,
				'updated_by' => $by,
				'education_major' => $req->education_major,
				'school' => $req->school,
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
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function UpdatetoParticipantFamily(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Participant_Family::select('id')->where('id', '=', $req->id)->first();

			Participant_Family::find($id->id)->update([
				'participant_id' => $req->participant_id,
				'family_relationship_id' => $req->family_relationship_id,
				'family_name' => $req->family_name,
				'email' => $req->email,
				'mobile_phone_number' => $req->mobile_phone_number,
				'birth_place' => strtoupper($req->birth_place),
				'birth_date' => $req->birth_date,
				'gender' => $req->gender,
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

	public function UpdatetoRegistration(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Registration::select('*')->where('registration_number', '=', $req->registration_number)->first();

			$data['updated_by'] = $by;

			if ($req->payment_method) {
				$data['payment_method_id'] = $req->payment_method;
			}
			if ($req->payment_status) {
				$data['payment_status_id'] = $req->payment_status;
			}
			if ($req->payment_date) {
				$data['payment_date'] = $req->payment_date;
			}
			if ($req->payment_approval_date) {
				$data['payment_approval_date'] = $req->payment_approval_date;
			}
			if ($req->payment_approval_by) {
				$data['payment_approval_by'] = $req->payment_approval_by;
			}
			if ($req->exam_status) {
				$data['exam_status'] = $req->exam_status;
			}
			if ($req->path_exam_detail) {
				$data['path_exam_detail_id'] = $req->path_exam_detail;
			}
			if ($req->active_status) {
				$data['active_status'] = $req->active_status;
			}
			if ($req->mapping_path_price_id) {
				$data['mapping_path_price_id'] = $req->mapping_path_price_id;
			}
			if ($req->payment_url) {
				$data['payment_url'] = env('FTP_URL') . $req->file('payment_url')->store('DEV/ADM/Selection/registration');
			}
			if ($req->activation_pin) {
				$data['activation_pin'] = $req->activation_pin;
			}

			if ($req->mapping_location_selection_id) {
				$data['mapping_location_selection_id'] = $req->mapping_location_selection_id;
			}

			if ($req->mapping_path_year_intake_id) {
				$data['mapping_path_year_intake_id'] = $req->mapping_path_year_intake_id;
			}

			$update = Registration::find($id->registration_number)->update($data);

			if (isset($req->payment_method)) {
				$data = Payment_Method::select('method')->where('id', '=', $req->payment_method)->first();
				DB::connection('pgsql')->commit();

				return response([
					'status' => 'Success',
					'message' => 'Data Tersimpan',
					'payment_method_id' => $req->payment_method,
					'payment_method_name' => $data->method,
					'registration_number' => $id->registration_number,
				], 200);
			} else {
				DB::connection('pgsql')->commit();

				return response([
					'status' => 'Success',
					'message' => 'Data Tersimpan',
					'payment_method_id' => $id->payment_method_id,
					'payment_method_name' => null,
					'registration_number' => $id->registration_number,
				], 200);
			}
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function UpdatetoDocument(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Document::select('id', 'url')->where('id', '=', $req->document_id)->first();

			$data['updated_by'] = $by;

			if ($req->name) {
				$data['name'] = $req->name;
			}
			if ($req->description) {
				$data['description'] = $req->description;
			}
			if ($req->number) {
				$data['number'] = $req->number;
			}
			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}
			if ($req->approval_final_status) {
				$data['approval_final_status'] = $req->approval_final_status;
			}
			if ($req->approval_final_date) {
				$data['approval_final_date'] = $req->approval_final_date;
			}
			if ($req->approval_final_by) {
				$data['approval_final_by'] = $req->approval_final_by;
			}
			if ($req->approval_final_comment) {
				$data['approval_final_comment'] = $req->approval_final_comment;
			}
			$update = Document::find($id->id)->update($data);

			DB::connection('pgsql')->commit();
			return response([
				'url' => $id->url,
				'approval_final_status' => $req->approval_final_status,
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

	public function UpdatetoQuestionare(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Questionare::select('id')->where('id', '=', $req->id)->first();
			$update = Questionare::find($id->id)->update([
				'name' => $req->name,
				'description' => $req->description,
				'selection_path_id' => $req->selection_path_id,
				'active_status' => $req->active_status,
				'updated_by' => $by,
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

	public function UpdatetoMappingLocationSelection(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Mapping_Location_Selection::select('id')->where('id', '=', $req->id)->first();
			$update = Mapping_Location_Selection::where('id', $id->id)->update([
				'selection_path_id' => $req->selection_path_id,
				'location_exam_id' => $req->location_exam_id,
				'active_status' => $req->active_status,
				'updated_by' => $by,
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data berhasil diubah'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diubah'
			], 500);
		}
	}

	public function UpdatetoQuestions(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Question::select('id')->where('id', '=', $req->id)->first();
			$update = Question::where('id', $id->id)->update([
				'questionare_id' => $req->questionare_id,
				'question_type_id' => $req->question_type_id,
				'detail' => $req->detail,
				'active_status' => $req->active_status,
				'updated_by' => $by,
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

	public function UpdatetoAnswerOption(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Answer_Option::select('id')->where('id', '=', $req->id)->first();
			$update = Answer_Option::where('id', $id->id)->update([
				'question_id' => $req->question_id,
				'value' => $req->value,
				'ordering' => $req->ordering,
				'updated_by' => $by,
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

	public function UpdatetoParticipantWorkData(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Participant_Work_Data::select('id')->where('id', '=', $req->id)->first();
			$update = Participant_Work_Data::find($id->id)->update([
				'participant_id' => $req->participant_id,
				'work_field_id' => $req->work_field_id,
				'company_name' => $req->company_name,
				'work_position' => $req->work_position,
				'work_start_date' => $req->work_start_date,
				'work_end_date' => $req->work_end_date,
				'company_address' => $req->company_address,
				'company_phone_number' => $req->company_phone_number,
				'updated_by' => $by,
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
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function UpdatetoMappingStudyProgram(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Mapping_Registration_Program_Study::select('id')->where('id', '=', $req->id)->first();
			$update = Mapping_Registration_Program_Study::find($id->id)->update([
				'registration_number' => $req->registration_number,
				'mapping_path_study_program_id' => $req->mapping_path_study_program_id,
				'program_study_id' => $req->program_study_id,
				'priority' => $req->priority,
				'education_fund' => $req->education_fund,
				'updated_by' => $by,
				'study_program_specialization_id' => $req->study_program_specialization_id
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

	public function UpdatetoDocumentReportCard(Request $req)
	{
		try {
			//document report card
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number != null) {
				$data['number'] = $req->number;
			}

			if ($req->approval_final_status) {
				$data['approval_final_status'] = $req->approval_final_status;
				$data['approval_final_date'] = Carbon::now();
				$data['approval_final_by'] = $by;
			}

			if ($req->approval_final_comment) {
				$data['approval_final_comment'] = $req->approval_final_comment;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;
			Document::find($id->id)->update($data);

			//document report card
			$id_report = Document_Report_Card::select('id')->where('id', '=', $req->report_id)->first();

			if ($req->semester_id) {
				$dataReport['semester_id'] = $req->semester_id;
			}

			if ($req->range_score) {
				$dataReport['range_score'] = $req->range_score;
			}

			if ($req->mapel1 != null) {
				$dataReport['mapel1'] = $req->mapel1;
			}

			if ($req->mapel2 != null) {
				$dataReport['mapel2'] = $req->mapel2;
			}

			if ($req->mapel3 != null) {
				$dataReport['mapel3'] = $req->mapel3;
			}

			if ($req->mapel4 != null) {
				$dataReport['mapel4'] = $req->mapel4;
			}

			if ($req->mapel5 != null) {
				$dataReport['mapel5'] = $req->mapel5;
			}

			if ($req->mapel6 != null) {
				$dataReport['mapel6'] = $req->mapel6;
			}

			if ($req->mapel7 != null) {
				$dataReport['mapel7'] = $req->mapel7;
			}

			if ($req->mapel8 != null) {
				$dataReport['mapel8'] = $req->mapel8;
			}

			if ($req->mapel9 != null) {
				$dataReport['mapel9'] = $req->mapel9;
			}

			if ($req->mapel10 != null) {
				$dataReport['mapel10'] = $req->mapel10;
			}

			if ($req->mapel11 != null) {
				$dataReport['mapel11'] = $req->mapel11;
			}

			if ($req->mapel12 != null) {
				$dataReport['mapel12'] = $req->mapel12;
			}

			if ($req->alias1 != null) {
				$dataReport['alias1'] = $req->alias1;
			}

			if ($req->alias2 != null) {
				$dataReport['alias2'] = $req->alias2;
			}

			if ($req->alias3 != null) {
				$dataReport['alias3'] = $req->alias3;
			}

			if ($req->alias4 != null) {
				$dataReport['alias4'] = $req->alias4;
			}

			if ($req->alias5 != null) {
				$dataReport['alias5'] = $req->alias5;
			}

			if ($req->alias6 != null) {
				$dataReport['alias6'] = $req->alias6;
			}

			if ($req->alias7 != null) {
				$dataReport['alias7'] = $req->alias7;
			}

			if ($req->alias8 != null) {
				$dataReport['alias8'] = $req->alias8;
			}

			if ($req->alias9 != null) {
				$dataReport['alias9'] = $req->alias9;
			}

			if ($req->alias10 != null) {
				$dataReport['alias10'] = $req->alias10;
			}

			if ($req->alias11 != null) {
				$dataReport['alias11'] = $req->alias11;
			}

			if ($req->alias12 != null) {
				$dataReport['alias12'] = $req->alias12;
			}

			if ($req->registration_number) {
				$dataReport['registration_number'] = $req->registration_number;
			}

			if ($req->gpa) {
				$dataReport['gpa'] = $req->gpa;
			}

			$dataReport['updated_by'] = $by;
			Document_Report_Card::find($id_report->id)->update($dataReport);

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

	public function UpdatetoDocumentUtbk(Request $req)
	{
		try {
			//document report card
			$by = $req->header("X-I");
			$id = Document::select('*')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number != null) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			if ($req->approval_final_status) {
				$data['approval_final_status'] = $req->approval_final_status;
				$data['approval_final_date'] = Carbon::now();
				$data['approval_final_by'] = $by;
			}

			if ($req->approval_final_comment) {
				$data['approval_final_comment'] = $req->approval_final_comment;
			}

			$data['updated_by'] = $by;
			Document::where('id', '=', $id->id)->update($data);

			//document utbk
			$id_utbk = Document_Utbk::select('id')->where('id', '=', $req->utbk_id)->first();

			if ($req->mapel1 != null) {
				$dataUtbk['mapel1'] = $req->mapel1;
			}
			if ($req->mapel2 != null) {
				$dataUtbk['mapel2'] = $req->mapel2;
			}
			if ($req->mapel3 != null) {
				$dataUtbk['mapel3'] = $req->mapel3;
			}
			if ($req->mapel4 != null) {
				$dataUtbk['mapel4'] = $req->mapel4;
			}
			if ($req->mapel5 != null) {
				$dataUtbk['mapel5'] = $req->mapel5;
			}
			if ($req->mapel6 != null) {
				$dataUtbk['mapel6'] = $req->mapel6;
			}
			if ($req->mapel7 != null) {
				$dataUtbk['mapel7'] = $req->mapel7;
			}
			if ($req->mapel8 != null) {
				$dataUtbk['mapel8'] = $req->mapel8;
			}
			if ($req->mapel9 != null) {
				$dataUtbk['mapel9'] = $req->mapel9;
			}
			if ($req->mapel10 != null) {
				$dataUtbk['mapel10'] = $req->mapel10;
			}

			if ($req->registration_number) {
				$dataUtbk['registration_number'] = $req->registration_number;
			}

			if ($req->general_reasoning != null) {
				$dataUtbk['general_reasoning'] = $req->general_reasoning;
			}

			if ($req->quantitative_knowledge != null) {
				$dataUtbk['quantitative_knowledge'] = $req->quantitative_knowledge;
			}

			if ($req->comprehension_general_knowledge != null) {
				$dataUtbk['comprehension_general_knowledge'] = $req->comprehension_general_knowledge;
			}

			if ($req->comprehension_reading_knowledge != null) {
				$dataUtbk['comprehension_reading_knowledge'] = $req->comprehension_reading_knowledge;
			}

			if ($req->major_type != null) {
				$dataUtbk['major_type'] = $req->major_type;
			}

			$dataUtbk['updated_by'] = $by;

			Document_Utbk::where('id', '=', $id_utbk->id)->update($dataUtbk);

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

	public function UpdatetoDocumentCertificate(Request $req)
	{
		try {
			//document report card
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;
			Document::find($id->id)->update($data);

			//document certificate
			$id_certificate = Document_Certificate::select('id')->where('id', '=', $req->certificate_id)->first();

			if ($req->certificate_type_id) {
				$dataCertificate['certificate_type_id'] = $req->certificate_type_id;
			}

			if ($req->certificate_level_id) {
				$dataCertificate['certificate_level_id'] = $req->certificate_level_id;
			}

			if ($req->publication_year) {
				$dataCertificate['publication_year'] = $req->publication_year;
			}

			if ($req->certificate_score) {
				$dataCertificate['certificate_score'] = $req->certificate_score;
			}

			if ($req->registration_number) {
				$dataCertificate['registration_number'] = $req->registration_number;
			}

			$dataCertificate['updated_by'] = $by;
			Document_Certificate::find($id_certificate->id)->update($dataCertificate);

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

	public function UpdatetoDocumentSupporting(Request $req)
	{
		try {
			//document
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;
			Document::find($id->id)->update($data);

			//document suppoting
			$id_support = Document_Supporting::select('id')->where('id', '=', $req->support_id)->first();

			if ($req->pic_name) {
				$dataSupporting['pic_name'] = $req->pic_name;
			}

			if ($req->pic_phone_number) {
				$dataSupporting['pic_phone_number'] = $req->pic_phone_number;
			}

			if ($req->pic_email_address) {
				$dataSupporting['pic_email_address'] = $req->pic_email_address;
			}

			if ($req->pic_address) {
				$dataSupporting['pic_address'] = $req->pic_address;
			}

			if ($req->registration_number) {
				$dataSupporting['registration_number'] = $req->registration_number;
			}

			$dataSupporting['updated_by'] = $by;
			Document_Supporting::find($id_support->id)->update($dataSupporting);

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

	public function UpdatetoDocumentStudy(Request $req)
	{
		try {
			//document
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;
			Document::find($id->id)->update($data);

			//document study
			$id_document_study = Document_Study::select('id')->where('id', '=', $req->document_study_id)->first();

			if ($req->score) {
				$document_study['score'] = $req->score;
			}

			if ($req->year) {
				$document_study['year'] = $req->year;
			}

			if ($req->registration_number) {
				$document_study['registration_number'] = $req->registration_number;
			}

			$document_study['updated_by'] = $by;
			Document_Study::find($id_document_study->id)->update($document_study);

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

	public function UpdatetoDocumentProposal(Request $req)
	{
		try {
			//document
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;
			Document::find($id->id)->update($data);

			//document study
			$id_document_study = Document_Study::select('id')->where('id', '=', $req->document_study_id)->first();

			if ($req->title) {
				$document_study['title'] = $req->title;
			}

			if ($req->registration_number) {
				$document_study['registration_number'] = $req->registration_number;
			}

			$document_study['updated_by'] = $by;
			Document_Study::find($id_document_study->id)->update($document_study);

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

	//update voucher data
	public function UpdatePinVoucher(Request $req)
	{
		$by = $req->header("X-I");

		try {
			if ($req->type) {
				$data['type'] = strtoupper($req->type);
			}

			if ($req->active_status) {
				$data['active_status'] = $req->active_status;
			}

			if ($req->expire_date) {
				$data['expire_date'] = $req->expire_date;
			}

			if ($req->price) {
				$data['price'] = $req->price;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->approved_at) {
				$data['approved_at'] = Carbon::now();
				$data['approved_by'] = $by;
			}

			if ($req->study_program_id) {
				$data['study_program_id'] = $req->study_program_id;
			}

			$data['updated_by'] = $by;

			$update = Pin_Voucher::find($req->voucher)->update($data);

			DB::connection('pgsql')->commit();

			return response([
				'status' => 'Success',
				'message' => 'Voucher diperbaruhi'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal diperbaruhi',
				'exception_message' => $e->getMessage()
			], 500);
		}
	}

	public function UpdateMappingPathYear(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$mpy = Mapping_Path_Year::where('id', '=', $req->id)->first();

			Mapping_Path_Year::find($mpy->id)->update([
				'selection_path_id' => (isset($_POST['selection_path_id'])) ? $req->selection_path_id : $mpy->selection_path_id,
				'year' => (isset($_POST['year'])) ? $req->year : $mpy->year,
				'school_year' => (isset($_POST['school_year'])) ? $req->school_year : $mpy->school_year,
				'active_status' => (isset($_POST['active_status'])) ? $req->active_status : $mpy->active_status,
				'updated_by' => $by,
				'start_date' => (isset($_POST['start_date'])) ? $req->start_date : $mpy->start_date,
				'end_date' => (isset($_POST['end_date'])) ? $req->end_date : $mpy->end_date
			]);
			DB::connection('pgsql')->commit();
			return response([
				'status' => 'Success',
				'message' => 'Data Tersimpan'
			], 200);
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return $e;
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan'
			], 500);
		}
	}

	public function UpdateMappingPathYearIntake(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$mpy = Mapping_Path_Year_Intake::where('id', '=', $req->id)->first();

			Mapping_Path_Year_Intake::find($mpy->id)->update([
				'mapping_path_year_id' => (isset($_POST['mapping_path_year_id'])) ? $req->mapping_path_year_id : $mpy->mapping_path_year_id,
				'semester' => (isset($_POST['semester'])) ? $req->semester : $mpy->semester,
				'school_year' => (isset($_POST['school_year'])) ? $req->school_year : $mpy->school_year,
				'notes' => (isset($_POST['notes'])) ? $req->notes : $mpy->notes,
				'active_status' => (isset($_POST['active_status'])) ? $req->active_status : $mpy->active_status,
				'year' => (isset($_POST['year'])) ? $req->year : $mpy->year,
				'nomor_reff' => (isset($_POST['nomor_reff'])) ? $req->nomor_reff : $mpy->nomor_reff,
				'updated_by' => $by
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

	//untuk menyimpan isian pemberi rekomendasi
	public function UpdateDocumentRecomendation(Request $req)
	{
		try {
			$document_recomendation = Document_Recomendation::select('*')
				->where('token', '=', $req->code)
				->first();

			if ($document_recomendation == null) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, data gagal disimpan. Dokumen tidak terdaftar'
				], 500);
			}

			if (!Hash::check($document_recomendation->id, $req->hash)) {
				return response()->json([
					'status' => 'Failed',
					'message' => 'Mohon maaf, data gagal disimpan. Hash tidak valid'
				], 500);
			}

			Document_Recomendation::find($document_recomendation->id)->update([
				'name' => (isset($req->name) != null) ? $req->name : $document_recomendation->name,
				'handphone' => (isset($req->handphone) != null) ? $req->handphone : $document_recomendation->handphone,
				'email' => (isset($req->email) != null) ? $req->email : $document_recomendation->email,
				'position' => (isset($req->position) != null) ? $req->position : $document_recomendation->position,
				'institution' => (isset($req->institution) != null) ? $req->institution : $document_recomendation->institution,
				'long_capacity_knowing_student' => (isset($req->long_capacity_knowing_student) != null) ? $req->long_capacity_knowing_student : $document_recomendation->long_capacity_knowing_student,
				'knowledge' => (isset($req->knowledge) != null) ? $req->knowledge : $document_recomendation->knowledge,
				'intellectual' => (isset($req->intellectual) != null) ? $req->intellectual : $document_recomendation->intellectual,
				'verbal_expression' => (isset($req->verbal_expression) != null) ? $req->verbal_expression : $document_recomendation->verbal_expression,
				'written_expression' => (isset($req->written_expression) != null) ? $req->written_expression : $document_recomendation->written_expression,
				'work_independently' => (isset($req->work_independently) != null) ? $req->work_independently : $document_recomendation->work_independently,
				'work_cooperate' => (isset($req->work_cooperate) != null) ? $req->work_cooperate : $document_recomendation->work_cooperate,
				'maturity' => (isset($req->maturity) != null) ? $req->maturity : $document_recomendation->maturity,
				'recomendation' => (isset($req->recomendation) != null) ? $req->recomendation : $document_recomendation->recomendation,
				'opinion' => (isset($req->opinion) != null) ? $req->opinion : $document_recomendation->opinion,
				'ip_address' => $this->getClientIp()
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

	//get client IP Address
	function getClientIp()
	{
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if (isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if (isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	//api for update announcement
	public function UpdateAnnoncementRegistrationCard(Request $req)
	{
		try {
			$by = $req->header("X-I");

			Announcement_Registration_Card::find($req->id)->update([
				'tittle' => $req->title,
				'start_date' => $req->start_date,
				'notes' => $req->notes,
				'active_status' => $req->active_status,
				'ordering' => $req->ordering,
				'exam_type' => $req->exam_type,
				'updated_by' => $by
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil memperbaruhi data pengumuman'
			], 200);
		} catch (Exception $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data pengumuman.',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for insert mapping report subject path
	public function UpdateMappingReportSubjectPath(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$datas = json_decode($req->json, true);

			//update to mapping path document
			Mapping_Path_Document::where('id', '=', $datas['id'])->update([
				'selection_path_id' => $datas['selection_path_id'],
				'document_type_id' => $datas['document_type_id'],
				'active_status' => $datas['active_status'],
				'required' => $datas['required'],
				'updated_by' => $by
			]);

			//update technic
			Mapping_Report_Subject_Path::find($datas['mapping_report_subject_path_technic']['id'])->update([
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
				'active_status' => $datas['mapping_report_subject_path_technic']['active_status'],
				'updated_by' => $by
			]);

			//update non technic
			Mapping_Report_Subject_Path::find($datas['mapping_report_subject_path_non_technic']['id'])->update([
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
				'active_status' => $datas['mapping_report_subject_path_non_technic']['active_status'],
				'updated_by' => $by
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil memperbaruhi data'
			], 200);
		} catch (Throwable $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api untuk update data passing grade
	public function UpdatePassingGrade(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$data = Passing_Grade::find($req->id);

			Passing_Grade::find($req->id)->update([
				'program_study_id' => ($req->program_study_id == null) ? $data->program_study_id : $req->program_study_id,
				'mapping_path_year_id' => ($req->mapping_path_year_id == null) ? $data->mapping_path_year_id : $req->mapping_path_year_id,
				'mapel1' => ($req->mapel1 == null) ? $data->mapel1 : $req->mapel1,
				'mapel2' => ($req->mapel2 == null) ? $data->mapel2 : $req->mapel2,
				'mapel3' => ($req->mapel3 == null) ? $data->mapel3 : $req->mapel3,
				'mapel4' => ($req->mapel4 == null) ? $data->mapel4 : $req->mapel4,
				'mapel5' => ($req->mapel5 == null) ? $data->mapel5 : $req->mapel5,
				'mapel6' => ($req->mapel6 == null) ? $data->mapel6 : $req->mapel6,
				'mapel7' => ($req->mapel7 == null) ? $data->mapel7 : $req->mapel7,
				'mapel8' => ($req->mapel8 == null) ? $data->mapel8 : $req->mapel8,
				'mapel9' => ($req->mapel9 == null) ? $data->mapel9 : $req->mapel9,
				'mapel10' => ($req->mapel10 == null) ? $data->mapel10 : $req->mapel10,
				'mapel11' => ($req->mapel11 == null) ? $data->mapel11 : $req->mapel11,
				'mapel12' => ($req->mapel12 == null) ? $data->mapel12 : $req->mapel12,
				'mapel13' => ($req->mapel13 == null) ? $data->mapel13 : $req->mapel13,
				'mapel14' => ($req->mapel14 == null) ? $data->mapel14 : $req->mapel14,
				'mapel15' => ($req->mapel15 == null) ? $data->mapel15 : $req->mapel15,
				'mapel16' => ($req->mapel16 == null) ? $data->mapel16 : $req->mapel16,
				'updated_by' => $by,
				'active_status' => ($req->active_status == null) ? $data->active_status : $req->active_status,
				'min_grade_value' => ($req->min_grade_value == null) ? $data->min_grade_value : $req->min_grade_value,
			]);

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

	//api for insert mapping report subject path
	public function UpdateMappingUtbkPath(Request $req)
	{
		try {
			$by = $req->header("X-I");

			//update non science
			Mapping_Utbk_Path::where('id', '=', $req->id)->update([
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
				'active_status' => $req->active_status,
				'updated_by' => $by
			]);

			return response()->json([
				'status' => 'Success',
				'message' => 'Berhasil memperbarui data'
			], 200);
		} catch (\Throwable $e) {
			return response()->json([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api untuk update approval participant grade by faculty
	public function UpdateApprovalParticipantGradeFaculty(Request $req)
	{
		$by = $req->header("X-I");

		try {
			Participant_Grade::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'approval_faculty' => $req->approval_faculty,
					'approval_faculty_by' => $by,
					'approval_faculty_at' => Carbon::now(),
					'grade_final' => $req->grade_final,
					'mapel11' => $req->mapel11,
					'mapel12' => $req->mapel12,
					'mapel13' => $req->mapel13,
					'mapel14' => $req->mapel14,
					'mapel15' => $req->mapel15,
					'mapel16' => $req->mapel16
				]
			);

			$mrps = Mapping_Registration_Program_Study::select()
				->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
				->where('mapping_registration_program_study.program_study_id', '=', $req->program_study_id)
				->first();

			Mapping_Registration_Program_Study::find($mrps->id)->update([
				'approval_faculty' => $req->approval_faculty,
				'approval_faculty_at' => Carbon::now(),
				'approval_faculty_by' => $by,
				'rank' => $req->rank
			]);

			$participant = Registration::select(
				'registrations.participant_id',
				'registrations.selection_path_id'
			)
				->where('registrations.registration_number', '=', $req->registration_number)
				->first();

			Registration_Result::updateOrCreate(
				[
					'registration_number' => $req->registration_number
				],
				[
					'registration_number' => $req->registration_number,
					'created_by' => $by,
					'total_score' => $req->grade_final,
					'pass_status' => $req->approval_faculty,
					'publication_status' => false,
					'program_study_id' => $mrps->program_study_id,
					'specialization_id' => $mrps->study_program_specialization_id,
					'participant_id' => $participant->participant_id,
					'rank' => $req->rank,
					'selection_path_id' => $participant->selection_path_id
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

	//api untuk update approval participant grade by university
	public function UpdateApprovalParticipantGradeUniversity(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$datas = json_decode($req->json, true);

			foreach ($datas as $key => $value) {
				Registration_Result::where('registration_number', '=', $value['registration_number'])->update([
					'approval_university' => $value['approval_university'],
					'approval_university_by' => $by,
					'approval_university_at' => Carbon::now()
				]);
			}

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

	public function UpdateMoodleUser(Request $req)
	{
		$by = $req->header("X-I");

		//get data moodle user
		$moodle_user = Moodle_Users::select('*')
			->where('id', '=', $req->participant_id)
			->first();

		//get participant data
		$participant = Participant::select(
			'participants.id',
			'participants.photo_url'
		)
			->where('participants.id', '=', $req->participant_id)
			->first();

		//validate selection path
		if ($participant == null || $moodle_user == null) {
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
			$formParam['wsfunction'] = 'local_trisakti_api_update_users';


			$formParam['users'][0]['username'] = $moodle_user->username;
			$formParam['users'][0]['password'] = $moodle_user->password;
			$formParam['users'][0]['firstname'] = $moodle_user->firstname;
			$formParam['users'][0]['lastname'] = $moodle_user->lastname;
			$formParam['users'][0]['email'] = $moodle_user->email;
			$formParam['users'][0]['idnumber'] = $moodle_user->id;
			$formParam['users'][0]['auth'] = "manual";
			// $formParam['users'][0]['userpicturepath'] = $participant->photo_url;
			// $formParam['users'][0]['userpicture'] = 1;

			//execute moodle
			$request = $http->post($url, ['form_params' => $formParam]);
			$response = json_decode($request->getBody(), true);

			if ($response['data'][0]['status'] == null || $response['data'][0]['status'] == false) {
				return response([
					'status' => 'Failed',
					'message' => 'Data gagal diperbaruhi',
					'response' => $response
				], 500);
			}

			Moodle_Users::where('moodle_users.id', '=', $participant->id)->update([
				'username' => $formParam['users'][0]['username'],
				'password' => $formParam['users'][0]['password'],
				'firstname' => $formParam['users'][0]['firstname'],
				'lastname' => $formParam['users'][0]['lastname'],
				'email' => $formParam['users'][0]['email'],
				'participant_id' => $participant->id,
				'auth' => $formParam['users'][0]['auth'],
				'json_response' => json_encode($response),
				'userpicturepath' => isset($formParam['users'][0]['userpicturepath']) == null ? null : $formParam['users'][0]['userpicturepath'],
				'userpicture' => isset($formParam['users'][0]['userpicture']) == null ? null : $formParam['users'][0]['userpicture'],
				'created_by' => $by
			]);

			return response([
				'status' => 'Success',
				'message' => 'Data diperbaruhi dalam moodle',
				'response' => $response
			], 200);
		} catch (\Exception $e) {
			return response([
				'status' => 'Failed',
				'message' => 'Gagal memperbaruhi data kedalam moodle',
				'error' => $e->getMessage()
			], 500);
		}
	}

	//api for updating document recomendation religion
	public function UpdateToDocumentPublication(Request $req)
	{
		try {
			//document report card
			$by = $req->header("X-I");
			$id = Document::select('id')->where('id', '=', $req->document_id)->first();

			if ($req->name) {
				$data['name'] = $req->name;
			}

			if ($req->description) {
				$data['description'] = $req->description;
			}

			if ($req->number != null) {
				$data['number'] = $req->number;
			}

			if ($req->url) {
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

				Storage::delete($id->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;

			Document::find($id->id)->update($data);

			//document report card
			$id_publication = Document_Publication::select('id')->where('id', '=', $req->document_publication_id)->first();

			if ($req->writer_name) {
				$dataPublication['writer_name'] = $req->writer_name;
			}

			if ($req->publication_writer_position_id) {
				$dataPublication['publication_writer_position_id'] = $req->publication_writer_position_id;
			}

			if ($req->title) {
				$dataPublication['title'] = $req->title;
			}

			if ($req->publication_type_id) {
				$dataPublication['publication_type_id'] = $req->publication_type_id;
			}

			if ($req->publish_date) {
				$dataPublication['publish_date'] = $req->publish_date;
			}

			if ($req->publication_link) {
				$dataPublication['publication_link'] = $req->publication_link;
			}

			$dataPublication['updated_by'] = $by;

			Document_Publication::find($id_publication->id)->update($dataPublication);

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

	//api for updating document participant
	public function UpdateToParticipantDocument(Request $req)
	{
		try {
			//document report card
			$by = $req->header("X-I");

			$participant_document = Participant_Document::find($req->id);
			$document = Document::find($participant_document->document_id);

			if ($req->url) {
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

				Storage::delete($document->url);
				$data['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$data['updated_by'] = $by;

			if ($req->approval_final_status) {
				$data['approval_final_status'] = $req->approval_final_status;
				$data['approval_final_date'] = Carbon::now();
				$data['approval_final_by'] = $by;
			}

			if ($req->approval_final_comment) {
				$data['approval_final_comment'] = $req->approval_final_comment;
			}

			$document->update($data);

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

	//function for updating new Student
	public function UpdateNewStudent(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$new_student = New_Student::find($req->id);

			//validate
			if ($new_student == null) {
				return response([
					'status' => 'Failed',
					'message' => 'Mohon maaf, data gagal disimpan',
					'error' => 'New Student Empty'
				], 500);
			}

			New_Student::find($req->id)->update([
				'registration_number' => (isset($req->registration_number) != null) ? $req->registration_number : $new_student->registration_number,
				'program_study_id' => (isset($req->program_study_id) != null) ? $req->program_study_id : $new_student->program_study_id,
				'email' => (isset($req->email) != null) ? $req->email : $new_student->email,
				'password' => (isset($req->password) != null) ? Hash::make($req->password) : $new_student->password,
				'student_id' => (isset($req->student_id) != null) ? $req->student_id : $new_student->student_id,
				'participant_id' => (isset($req->participant_id) != null) ? $req->participant_id : $new_student->participant_id,
				'updated_by' => $by
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

	public function UpdatetoParticipantNewStudent(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$data['updated_by'] = $by;

			if ($req->fullname) {
				$data['fullname'] = $req->fullname;
			}
			if ($req->gender) {
				$data['gender'] = $req->gender;
			}
			if ($req->religion) {
				$data['religion'] = $req->religion;
			}
			if ($req->birth_country) {
				$data['birth_country'] = $req->birth_country;
			}
			if ($req->birth_province) {
				$data['birth_province'] = $req->birth_province;
			}
			if ($req->birth_city) {
				$data['birth_city'] = $req->birth_city;
			}
			if ($req->birth_place) {
				$data['birth_place'] = strtoupper($req->birth_place);
			}
			if ($req->birth_date) {
				$data['birth_date'] = $req->birth_date;
			}
			if ($req->nationality) {
				$data['nationality'] = $req->nationality;
			}
			if ($req->origin_country) {
				$data['origin_country'] = $req->origin_country;
			}
			if ($req->identify_number) {
				$data['identify_number'] = $req->identify_number;
				$data['passport_number'] = null;
				$data['passport_expiry_date'] = null;
			}
			if ($req->passport_number) {
				$data['passport_number'] = $req->passport_number;
				$data['identify_number'] = null;
			}
			if ($req->passport_expiry_date) {
				$data['passport_expiry_date'] = $req->passport_expiry_date;
			}
			if ($req->address_country) {
				$data['address_country'] = $req->address_country;
			}
			if ($req->address_province) {
				$data['address_province'] = $req->address_province;
			}
			if ($req->address_city) {
				$data['address_city'] = $req->address_city;
			}
			if ($req->address_disctrict) {
				$data['address_disctrict'] = $req->address_disctrict;
			}
			if ($req->address_detail) {
				$data['address_detail'] = $req->address_detail;
			}
			if ($req->address_postal_code) {
				$data['address_postal_code'] = $req->address_postal_code;
			}
			if ($req->house_phone_number) {
				$data['house_phone_number'] = $req->house_phone_number;
			}
			if ($req->mobile_phone_number) {
				$data['mobile_phone_number'] = $req->mobile_phone_number;
			}
			if ($req->photo_url) {
				//validate size file if size > 2 mb break program
				$validate = Validator::make($req->all(), [
					'photo_url' => 'file|max:2100'
				]);

				if ($validate->fails()) {
					return response([
						'status' => 'Failed',
						'message' => 'Mohon maaf, ukuran photo harus lebih kecil dari 2 Mb'
					], 500);
				}

				$data['photo_url'] = env('FTP_URL') . $req->file('photo_url')->store('DEV/ADM/Selection/participant');
			}
			if ($req->color_blind) {
				$data['color_blind'] = $req->color_blind;
			}
			if ($req->special_needs) {
				$data['special_needs'] = $req->special_needs;
			} else {
				$data['special_needs'] = null;
			}
			if ($req->birth_province_foreign) {
				$data['birth_province_foreign'] = $req->birth_province_foreign;
				$data['birth_province'] = null;
				$data['birth_city'] = null;
			}
			if ($req->birth_city_foreign) {
				$data['birth_city_foreign'] = $req->birth_city_foreign;
				$data['birth_province'] = null;
				$data['birth_city'] = null;
			}
			if ($req->nisn) {
				$data['nisn'] = $req->nisn;
			}
			if ($req->nis) {
				$data['nis'] = $req->nis;
			}
			if ($req->size_almamater) {
				$data['size_almamater'] = $req->size_almamater;
			}
			if ($req->diploma_number) {
				$data['diploma_number'] = $req->diploma_number;
			}

			$id = Participant::select('id')->where('username', '=', $req->username)->first();
			Participant::find($id->id)->update($data);

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

	public function UpdatetoParticipantFamilyNewStudent(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$father_name = isset($req->father_name) || isset($req->father_name) != "" ? $req->father_name : null;
			$father_mobile_phone_number = isset($req->father_mobile_phone_number) || isset($req->father_mobile_phone_number) != "" ? $req->father_mobile_phone_number : null;
			$father_identify_number = isset($req->father_identify_number) || isset($req->father_identify_number) != "" ? $req->father_identify_number : null;
			$mother_name = isset($req->mother_name) || isset($req->mother_name) != "" ? $req->mother_name : null;
			$mother_mobile_phone_number = isset($req->mother_mobile_phone_number) || isset($req->mother_mobile_phone_number) != "" ? $req->mother_mobile_phone_number : null;
			$mother_identify_number = isset($req->mother_identify_number) || isset($req->mother_identify_number) != "" ? $req->mother_identify_number : null;
			$guardian_name = isset($req->guardian_name) || isset($req->guardian_name) != "" ? $req->guardian_name : null;
			$guardian_mobile_phone_number = isset($req->guardian_mobile_phone_number) || isset($req->guardian_mobile_phone_number) != "" ? $req->guardian_mobile_phone_number : null;
			$guardian_identify_number = isset($req->guardian_identify_number) || isset($req->guardian_identify_number) != "" ? $req->guardian_identify_number : null;
			$participant_id = $req->participant_id;
			$is_guardian = $req->is_guardian;

			//change status active old participant family data
			if ($is_guardian) {
				//change status active father and mother
				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 1)
					->update([
						'active_status' => false,
						'updated_by' => $by
					]);

				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 2)
					->update([
						'active_status' => false,
						'updated_by' => $by
					]);

				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 3)
					->update([
						'active_status' => true,
						'updated_by' => $by
					]);
			} else {
				//change status active guardian
				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 3)
					->update([
						'active_status' => false,
						'updated_by' => $by
					]);

				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 1)
					->update([
						'active_status' => true,
						'updated_by' => $by
					]);

				Participant_Family::where('participant_id', '=', $participant_id)
					->where('family_relationship_id', '=', 2)
					->update([
						'active_status' => true,
						'updated_by' => $by
					]);
			}

			//insert new data
			if ($is_guardian) {
				//insert guardian
				Participant_Family::updateOrCreate(
					[
						'family_relationship_id' => 3,
						'participant_id' => $participant_id
					],
					[
						'family_relationship_id' => 3,
						'participant_id' => $participant_id,
						'family_name' => $guardian_name,
						'mobile_phone_number' => $guardian_mobile_phone_number,
						'identify_number' => $guardian_identify_number,
						'updated_by' => $by
					]
				);
			} else {
				//insert father and mother
				Participant_Family::updateOrCreate(
					[
						'family_relationship_id' => 1,
						'participant_id' => $participant_id
					],
					[
						'family_relationship_id' => 1,
						'participant_id' => $participant_id,
						'family_name' => $father_name,
						'mobile_phone_number' => $father_mobile_phone_number,
						'identify_number' => $father_identify_number,
						'updated_by' => $by
					]
				);

				Participant_Family::updateOrCreate(
					[
						'family_relationship_id' => 2,
						'participant_id' => $participant_id
					],
					[
						'family_relationship_id' => 2,
						'participant_id' => $participant_id,
						'family_name' => $mother_name,
						'mobile_phone_number' => $mother_mobile_phone_number,
						'identify_number' => $mother_identify_number,
						'updated_by' => $by
					]
				);
			}

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

	//function for approved document new student
	public function UpdateDocumentNewStudentToApproved(Request $req)
	{
		$by = $req->header("X-I");

		try {
			Document::find($req->document_id)->update([
				'approval_final_status' => true,
				'approval_final_date' => Carbon::now(),
				'approval_final_by' => $by,
				'approval_final_comment' => null,
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

	//function for rejected document new student
	public function UpdateDocumentNewStudentToRejected(Request $req)
	{
		$by = $req->header("X-I");

		try {
			Document::find($req->document_id)->update([
				'approval_final_status' => false,
				'approval_final_date' => Carbon::now(),
				'approval_final_by' => $by,
				'approval_final_comment' => $req->approval_final_comment,
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

	//function for generating NIM new-student
	public function UpdateStudentIdNewStudent(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$data = New_Student::find($req->id);

			//clear student_id before updating to new student_id
			New_Student::find($data->id)->update([
				'student_id' => null,
				'updated_by' => $by
			]);

			$student_id = $this->GenerateStudentIdNumber($data->registration_number, $data->program_study_id);

			//insert new student_id after updating to null
			New_Student::find($data->id)->update([
				'student_id' => $student_id,
				'email' => $student_id . "@trisakti.ac.id",
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
		$program_study = str_pad($data->program_study_id, 4, '0', STR_PAD_LEFT);

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

	//function for update item document transcript via participant
	public function UpdateMappingDocumentTranscriptParticipant(Request $req)
	{
		try {
			$by = $req->header("X-I");

			$datas = json_decode($req->json, true);

			//update document transcript
			$dt = Document_Transcript::find($req->document_transcript_id);

			Document_Transcript::find($dt->id)->update([
				'total_credit' => $datas['total_credit'],
				'total_course' => $datas['total_course']
			]);

			//update document
			if (isset($req->url)) {
				$uDocument['url'] = env('FTP_URL') . $req->file('url')->store('DEV/ADM/Selection/participant');
			}

			$uDocument['updated_by'] = $by;

			Document::find($dt->document_id)
				->update($uDocument);

			//update mapping 
			foreach ($datas['courses'] as $key => $value) {
				Mapping_Transcript_Participant::where('id', '=', $value['id'])
					->where('document_transcript_id', '=', $dt->id)
					->update([
						'course_code' => $value['course_code'],
						'course_name' => $value['course_name'],
						'credit_hour' => $value['credit_hour'],
						'grade' => $value['grade'],
						'document_transcript_id' => $dt->id,
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

	//function for update item document transcript via admin
	public function UpdateMappingDocumentTranscriptAdmin(Request $req)
	{
		$by = $req->header("X-I");

		try {
			$dc = Document_Transcript::find($req->document_transcript_id);

			//update mapping document transcript
			$datas = json_decode($req->json, true);

			foreach ($datas as $key => $value) {
				Mapping_Transcript_Participant::where('id', '=', $value['id'])
					->where('document_transcript_id', '=', $dc->id)
					->update([
						'course_code_approved' => $value['course_code_approved'],
						'course_name_approved' => $value['course_name_approved'],
						'credit_hour_approved' => $value['credit_hour_approved'],
						'grade_approved' => $value['grade_approved'],
						'approval_at' => Carbon::now(),
						'approval_by' => $by
					]);
			}
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

	public function UpdateExamType(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Exam_Type::select('id')->where('id', '=', $req->id)->first();
			$update = Exam_Type::find($id->id)->update([
				'id' => $req->id,
				'name' => $req->name,
				'active_status' => $req->active_status,
			]);
			DB::connection('pgsql')->commit();
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

	public function UpdateCategory(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$category = Category::findOrFail($req->id);
			$category->update([
				'name' => $req->name,
				'status' => $req->status,
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

	public function UpdateSelectionCategory(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Selection_Category::select('id')->where('id', '=', $req->id)->first();
			$update = Selection_Category::find($id->id)->update([
				'id' => $req->id,
				'name' => $req->name,
				'description' => $req->description,
				'active_status' => $req->active_status
			]);
			DB::connection('pgsql')->commit();
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

	public function UpdateForms(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$form = Form::findOrFail($req->id);
			$form->update([
				'name' => $req->name,
				'status' => $req->status,
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

	public function UpdateSchedule(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Schedule::findOrFail($req->id);
			$schedule->update([
				'selection_path_id' => $req->selection_path_id,
				'category_id' => $req->category_id,
				'session' => $req->session,
				'date' => $req->date,
				'status' => $req->status,
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
	public function UpdateDocumentCategories(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Document_Categories::findOrFail($req->id);
			$schedule->update([
				'name' => $req->name,
				'status' => $req->status,
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
			],  500);
		}
	}

	public function UpdateSelectionCategories(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Selection_Categories::findOrFail($req->id);
			$schedule->update([
				'name' => $req->name,
				'status' => $req->status,
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
			],  500);
		}
	}

	public function UpdateStudentInterest(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Education_Major::where('id', $req->id);
			$schedule->update([
				'major' => $req->major,
				'education_degree_id' => $req->education_degree_id,
				'created_by' => $req->created_by,
				'updated_by' => $req->updated_by,
				'created_at' => $req->created_at,
				'updated_at' => $req->updated_at,
				'is_technic' => $req->is_technic,
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

	public function UpdateEducationDegree(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Education_Degree::findOrFail($req->id);
			$schedule->update([
				'level' => $req->level,
				'description' => $req->description,
				'created_by' => $req->created_by,
				'updated_by' => $req->updated_by,
				'created_at' => $req->created_at,
				'updated_at' => $req->updated_at,
				'type' => $req->type
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

	public function UpdateStudyProgram(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$schedule = Study_Program::where('classification_id', $req->id);
			$schedule->update([
				'category' => $req->category,
				'classification_name' => $req->classification_name,
				'study_program_branding_name' => $req->study_program_name,
				'study_program_name' => $req->study_program_name,
				'acronim' => $req->acronim,
				'quota' => $req->quota,
				'sks' => $req->sks
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

	public function UpdateMappingProdiCategory(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$mappingprodicategory = Mapping_Prodi_Category::findOrFail($req->id);
			$mappingprodicategory->update([
				'prodi_fk' => $req->prodi_fk,
				'nama_prodi' => $req->nama_prodi,
				'dokumen_fk' => $req->dokumen_fk,
				'nama_dokumen' => $req->nama_dokumen,
				'selectedstatus' => $req->selectedstatus,
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

	public function UpdateMappingProdiFormulir(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$mappingprodiformulir = Mapping_Prodi_Formulir::findOrFail($req->id);
			$mappingprodiformulir->update([
				'prodi_fk' => $req->prodi_fk,
				'nama_prodi' => $req->nama_prodi,
				'nama_formulir' => $req->nama_formulir,
				'harga' => $req->harga,
				'add_cost' => $req->add_cost,
				'exam_status' => $req->exam_status,
				'kategori_formulir' => $req->kategori_formulir,
			]);
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

	public function UpdateMappingProdiBiaya(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$mappingprodibiaya = Mapping_Prodi_Biaya::findOrFail($req->id);
			$mappingprodibiaya->update([
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

	public function UpdateMasterMataPelajaran(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$MasterMataPelajaran = Master_Matpel::findOrFail($req->id);
			$MasterMataPelajaran->update([
				'name' => $req->name,
			]);
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

	public function UpdateStudyProgramSpecialization(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$MasterKelas = Study_Program_Specialization::where('id', $req->id);
			$MasterKelas->update([
				'specialization_name' => $req->specialization_name,
				'specialization_code' => $req->specialization_code,
				'active_status' => $req->active_status,
				'class_type' => $req->class_type,
				'class_type_id' => $req->class_type_id,
				'classification_id' => $req->classification_id,
			]);
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

	public function UpdateFaculty(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$study_program = Study_Program::where('classification_id', $req->classification_id)->first();
			$study_program->update([
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

	public function UpdateDocumentType(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$document = Document_Type::where('id', $req->id)->first();
			New_Student_Document_Type::updateOrCreate(
				[
					'id' => $document->id,
				],
				[
					'document_type_id' => $document->id,
					'name' => $req->name,
				]
			);
			$document->update([
				'name' => $req->name,
				'description' => $req->description,

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

	public function UpdatePackageQuestionUsers(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$data = CBT_Package_Question_Users::where('id', $req->id)->first();
			$data->update([
				'package_question_id' => $req->package_question_id,
				'user_id' => $req->user_id,
				'classes' => $req->classes,
				'date_exam' => $req->date_exam,
				'date_start' => $req->date_start,
				'date_end' => $req->date_end,
				'status' => $req->status
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

	public function UpdateTransferCredit(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$data = Transfer_Credit::where('id', $req->id)->first();
			$data->update([
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

	public function UpdateMasterPackage(Request $req)
	{
		try {
			DB::connection('pgsql')->beginTransaction();
			$datas = json_decode($req->json);

			$paket = Master_Package::where('id', '=', $req->id)->first();
			Master_Package_Angsuran::where('package_id', $paket->id)->delete();
			$paket->update([
				'nama_paket'  	=> json_decode($req->nama_paket),
				'angsuran' 		=> $req->angsuran,
				'study_program_id' => $req->study_program_id,
			]);

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

	public function UpdatePinTransaction(Request $request)
	{
		try {
			$client_id = env('CLIENT_ID'); //client id from BNI
			$secret_key = env('SECRET_VA'); // secret key from BNI
			$body = $request->getContent();
			$data_json = json_decode($body, true);

			if (!$data_json) {
				return response()->json([
					'status' => '999',
					'message' => 'Invalid request data'
				], 400);
			}

			if ($data_json['client_id'] != $client_id) {
				return response()->json([
					'status' => '999',
					'message' => 'Unauthorized access'
				], 401);
			}

			$data_asli = BniEnc::decrypt(
				$data_json['data'],
				$client_id,
				$secret_key
			);


			if (!$data_asli) {
				return response()->json([
					'status' => '999',
					'message' => 'Invalid data or incorrect secret key'
				], 400);
			}

			// Insert data_asli into your database using Eloquent
			$model = Transaction_Request::where([
				'client_id' => $data_json['client_id'],
				'trx_id' => $data_asli['trx_id']
			])->first();

			if ($model) {
				Registration::where('registration_number', $model->registration_number)->update([
					'payment_status_id' => 1,
					'payment_date' => Carbon::now(),
					'activation_pin' => true,
					'payment_url' => "VA Callback",
				]);
			}

			$billing = Transaction_Billing::where('trx_id', $data_asli['trx_id'])->first();

			if ($billing) {
				Registration_Result::where('registration_number', $billing->registration_number)->update(
					[
						'payment_status' => "Lunas",
						'payment_date' => Carbon::now(),
						'payment_url' => "VA Callback",
					]
				);
			}

			return response()->json([
				'status' => 'Success',
				'message' => 'Data update successfully',
			], 200);
		} catch (\Throwable $th) {
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $th->getMessage()
			], 500);
		}
	}

	public function UpdatetoRegistrationResult(Request $req)
	{
		try {
			$by = $req->header("X-I");
			$id = Registration_Result::select('*')->where('registration_number', '=', $req->registration_number)->first();

			$data['updated_by'] = $by;

			if ($req->payment_method) {
				$data['payment_method_id'] = $req->payment_method;
			}
			if ($req->payment_status) {
				$data['payment_status'] = $req->payment_status;
			}
			if ($req->payment_date) {
				$data['payment_date'] = $req->payment_date;
			}
			if ($req->payment_approval_date) {
				$data['payment_approval_date'] = $req->payment_approval_date;
			}
			if ($req->payment_approval_by) {
				$data['payment_approval_by'] = $req->payment_approval_by;
			}

			if ($req->payment_url) {
				$data['payment_url'] = env('FTP_URL') . $req->file('payment_url')->store('DEV/ADM/Selection/registration_result');
			}


			$update = Registration_Result::where('registration_number', '=', $req->registration_number)->update($data);

			if (isset($req->payment_method)) {
				$data = Payment_Method::select('method')->where('id', '=', $req->payment_method)->first();
				DB::connection('pgsql')->commit();

				return response([
					'status' => 'Success',
					'message' => 'Data Tersimpan',
					'payment_method_id' => $req->payment_method,
					'payment_method_name' => $data->method,
					'registration_number' => $id->registration_number,
				], 200);
			} else {
				DB::connection('pgsql')->commit();

				return response([
					'status' => 'Success',
					'message' => 'Data Tersimpan',
					'payment_method_id' => $id->payment_method_id,
					'payment_method_name' => null,
					'registration_number' => $id->registration_number,
				], 200);
			}
		} catch (\Exception $e) {
			DB::connection('pgsql')->rollBack();
			return response([
				'status' => 'Failed',
				'message' => 'Mohon maaf, data gagal disimpan',
				'error' => $e->getMessage()
			], 500);
		}
	}

	public function UpdateStatusChangePrograms(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$data = Change_Program::where('registration_number', $req->registration_number)->first();
			$data->update([
				'approval_fakultas' => (isset($req->approval_fakultas) != null) ? $req->approval_fakultas : $change_programs->approval_fakultas ?? '',
				'approval_fakultas_date' => (isset($req->approval_fakultas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
				'approval_fakultas_by' => (isset($req->approval_fakultas) != null) ? $by : $change_programs->approval_fakultas_by ?? '',
				'approval_universitas' => (isset($req->approval_universitas) != null) ? $req->approval_universitas : $change_programs->approval_universitas ?? '',
				'approval_universitas_by' => (isset($req->approval_universitas) != null) ? $by : $change_programs->approval_universitas_by ?? '',
				'approval_universitas_date' => (isset($req->approval_universitas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
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

	public function UpdateStatusRefund(Request $req)
	{
		$by = $req->header("X-I");
		try {
			$data = Refund_Request::where('registration_number', $req->registration_number)->first();
			$data->update([
				'approval_keuangan' => (isset($req->approval_keuangan) != null) ? $req->approval_keuangan : $change_programs->approval_keuangan ?? '',
				'approval_keuangan_date' => (isset($req->approval_keuangan) != null) ? now() : $change_programs->approval_universitas_date ?? null,
				'approval_keuangan_by' => (isset($req->approval_keuangan) != null) ? $by : $change_programs->approval_keuangan_by ?? '',
				'approval_fakultas' => (isset($req->approval_fakultas) != null) ? $req->approval_fakultas : $change_programs->approval_fakultas ?? '',
				'approval_fakultas_date' => (isset($req->approval_fakultas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
				'approval_fakultas_by' => (isset($req->approval_fakultas) != null) ? $by : $change_programs->approval_fakultas_by ?? '',
				'approval_universitas' => (isset($req->approval_universitas) != null) ? $req->approval_universitas : $change_programs->approval_universitas ?? '',
				'approval_universitas_by' => (isset($req->approval_universitas) != null) ? $by : $change_programs->approval_universitas_by ?? '',
				'approval_universitas_date' => (isset($req->approval_universitas) != null) ? now() : $change_programs->approval_universitas_date ?? null,
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
}
