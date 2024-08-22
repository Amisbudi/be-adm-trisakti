<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use App\Http\Models\ADM\StudentAdmission\Registration;
use App\Http\Models\ADM\StudentAdmission\Registration_Result;
use App\Http\Models\ADM\StudentAdmission\Registration_Result_Sync;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;

class RegistrationResultBulk extends Model implements ToCollection
{
	function __construct($by = null)
	{
		$this->by = $by;
	}

	public function collection(Collection $rows)
	{
		$count = 0;

		$registration_number_list = array();
		foreach ($rows as $row) {
			//disable first row, Heading Row
			if ($count == 0) {
				$count++;
				continue;
			}

			if ($row[0] == null) {
				continue;
			}

			array_push($registration_number_list, [
				'registration_number' => $row[0],
				'total_score' => $row[1],
				'pass_status' => $row[2],
				'publication_status' => $row[3],
				'publication_date' => ($row[4] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]),
				'program_study_id' => $row[5],
				'schoolarship_id' => $row[23],
				'up3' => $row[8],
				'bpp' => $row[12],
				'sdp2' => $row[16],
				'dormitory' => $row[20],
				'up3discount' => $row[9],
				'bppdiscount' => $row[13],
				'sdp2discount' => $row[17],
				'dormitorydiscount' => $row[21],
				'semester' => $row[27],
				'insurance' => $row[22],
				'notes' => $row[28],
				'start_date_1' => ($row[10] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
				'start_date_2' => ($row[14] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
				'start_date_3' => ($row[18] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[18]),
				'end_date_1' => ($row[11] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11]),
				'end_date_2' => ($row[15] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
				'end_date_3' => ($row[19] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19]),
				'schoolyear' => $row[7],
				'type' => $row[24],
				'oldstudentid' => $row[26],
				'reference_number' => $row[25],
				'updated_by' => $this->by,
				'created_by' => $this->by
			]);
		}

		foreach ($this->GetRegistrationDetails($registration_number_list) as $key => $value) {
			try {
				Registration_Result::updateOrCreate([
					'registration_number' => $value['registration_number']
				], $value);
				DB::connection('pgsql')->commit();
			} catch (\Exception $th) {
				DB::connection('pgsql')->rollBack();
			}
		}

		foreach ($this->GetRegistrationDetails($registration_number_list) as $key => $value) {
			//validate registration before insert
			$isUpdate = Registration_Result_Sync::where('registration_number', '=', $value['registration_number'])->first();

			if ($isUpdate == null) {
				$sync = "INSERT";
			} else {
				$sync = "UPDATE";
			}

			try {
				Registration_Result_Sync::create([
					'registration_number' => $value['registration_number'],
					'total_score' => $value['total_score'],
					'pass_status' => $value['pass_status'],
					'publication_status' => $value['publication_status'],
					'publication_date' => $value['publication_date'],
					'created_by' => $value['created_by'],
					'updated_by' => $value['updated_by'],
					'participant_id' => $value['participant_id'],
					'selection_path_id' => $value['selection_path_id'],
					'program_study_id' => $value['program_study_id'],
					'scholarship_id' => $value['schoolarship_id'],
					'up3' => $value['up3'],
					'bpp' => $value['bpp'],
					'sdp2' => $value['sdp2'],
					'dormitory' => $value['dormitory'],
					'up3discount' => $value['up3discount'],
					'bppdiscount' => $value['bppdiscount'],
					'sdp2discount' => $value['sdp2discount'],
					'dormitorydiscount' => $value['dormitorydiscount'],
					'semester' => $value['semester'],
					'insurance' => $value['insurance'],
					'notes' => $value['notes'],
					'start_date_1' => $value['start_date_1'],
					'start_date_2' => $value['start_date_2'],
					'start_date_3' => $value['start_date_3'],
					'end_date_1' => $value['end_date_1'],
					'end_date_2' => $value['end_date_2'],
					'end_date_3' => $value['end_date_3'],
					'schoolyear' => $value['schoolyear'],
					'type' => $value['type'],
					'oldstudentid' => $value['oldstudentid'],
					'reference_number' => $value['reference_number'],
					'selection_program_name' => $value['selection_program_name'],
					'selection_program_id' => $value['selection_program_id'],
					'password' => 'PWD' . $value['participant_id'] . $value['selection_path_id'],
					'action' => $sync
				]);

				DB::connection('pgsql')->commit();
			} catch (\Exception $th) {
				DB::connection('pgsql')->rollBack();
			}
		}
	}

	function GetRegistrationDetails($registration_number_list)
	{
		$data = Registration::select(
			'registrations.registration_number',
			'p.id as participant_id',
			'sp.id as selection_path_id',
			'sps.id as selection_program_id',
			'sps.name as selection_program_name'
		)
			->leftjoin('participants as p', 'registrations.participant_id', '=', 'p.id')
			->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
			->leftjoin('selection_programs as sps', 'sp.selection_program_id', '=', 'sps.id')
			->whereIn('registrations.registration_number', array_column($registration_number_list, 'registration_number'))
			->get();

		$result = array();

		foreach ($data as $key => $valueDb) {
			foreach ($registration_number_list as $key2 => $valueExcel) {
				if ($valueDb['registration_number'] == $valueExcel['registration_number']) {
					array_push($result, [
						'registration_number' => $valueExcel['registration_number'],
						'total_score' => $valueExcel['total_score'],
						'pass_status' => $valueExcel['pass_status'],
						'publication_status' => $valueExcel['publication_status'],
						'publication_date' => $valueExcel['publication_date'],
						'created_by' => $valueExcel['created_by'],
						'updated_by' => $valueExcel['updated_by'],
						'participant_id' => $valueDb['participant_id'],
						'selection_path_id' => $valueDb['selection_path_id'],
						'program_study_id' => $valueExcel['program_study_id'],
						'schoolarship_id' => $valueExcel['schoolarship_id'],
						'up3' => $valueExcel['up3'],
						'bpp' => $valueExcel['bpp'],
						'sdp2' => $valueExcel['sdp2'],
						'dormitory' => $valueExcel['dormitory'],
						'up3discount' => $valueExcel['up3discount'],
						'bppdiscount' => $valueExcel['bppdiscount'],
						'sdp2discount' => $valueExcel['sdp2discount'],
						'dormitorydiscount' => $valueExcel['dormitorydiscount'],
						'semester' => $valueExcel['semester'],
						'insurance' => $valueExcel['insurance'],
						'notes' => $valueExcel['notes'],
						'start_date_1' => $valueExcel['start_date_1'],
						'start_date_2' => $valueExcel['start_date_2'],
						'start_date_3' => $valueExcel['start_date_3'],
						'end_date_1' => $valueExcel['end_date_1'],
						'end_date_2' => $valueExcel['end_date_2'],
						'end_date_3' => $valueExcel['end_date_3'],
						'schoolyear' => $valueExcel['schoolyear'],
						'type' => $valueExcel['type'],
						'oldstudentid' => $valueExcel['oldstudentid'],
						'reference_number' => $valueExcel['reference_number'],
						'selection_program_name' => $valueDb['selection_program_name'],
						'selection_program_id' => $valueDb['selection_program_id'],
						'password' => $valueDb['participant_id'] . $valueDb['selection_path_id']
					]);
					continue;
				}
			}
		}

		return $result;
	}
}
