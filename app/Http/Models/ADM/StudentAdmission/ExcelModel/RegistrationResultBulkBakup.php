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
		$registration_number_list = array();

		$count = 0;
		foreach ($rows as $row) {
			//disable first row, Heading Row
			if ($count == 0) {
				$count++;
				continue;
			}

			if ($row[0] == null) {
				continue;
			}

			try {
				//validate registration before insert
				$isUpdate = Registration_Result::where('registration_number', '=', $row[0])
					->first();

				if ($isUpdate == null) {
					$sync = "INSERT";
				} else {
					$sync = "UPDATE";
				}

				Registration_Result::updateOrCreate(
					[
						'registration_number' => $row[0]
					],
					[
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
						'semester' => $row[28],
						'insurance' => $row[22],
						'notes' => $row[29],
						'start_date_1' => ($row[10] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
						'start_date_2' => ($row[14] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
						'start_date_3' => ($row[18] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[18]),
						'end_date_1' => ($row[11] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11]),
						'end_date_2' => ($row[15] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
						'end_date_3' => ($row[19] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19]),
						'schoolyear' => $row[7],
						'type' => $row[24],
						'oldstudentid' => $row[27],
						'reference_number' => $row[25],
						'password' => $row[26],
						'updated_by' => $this->by
					]
				);

				Registration_Result_Sync::create([
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
					'semester' => $row[28],
					'insurance' => $row[22],
					'notes' => $row[29],
					'start_date_1' => ($row[10] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10]),
					'start_date_2' => ($row[14] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14]),
					'start_date_3' => ($row[18] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[18]),
					'end_date_1' => ($row[11] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[11]),
					'end_date_2' => ($row[15] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15]),
					'end_date_3' => ($row[19] == null) ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[19]),
					'schoolyear' => $row[7],
					'type' => $row[24],
					'oldstudentid' => $row[27],
					'reference_number' => $row[25],
					'password' => $row[26],
					'etl_time' => Carbon::now(),
					'created_by' => $this->by,
					'updated_by' => $this->by,
					'action' => $sync
				]);

				array_push($registration_number_list, $row[0]);

				DB::connection('pgsql')->commit();
			} catch (\Exception $e) {
				DB::connection('pgsql')->rollBack();
			}
		}

		//update data registration from participant
		$participants = Registration::select(
			'registrations.registration_number',
			'p.id as participant_id',
			'sp.id as selection_path_id',
			'sp.name as selection_path_name',
			'sps.id as selection_program_id',
			'sps.name as selection_program_name'
		)
			->join('participants as p', 'registrations.participant_id', '=', 'p.id')
			->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
			->join('selection_programs as sps', 'sp.selection_program_id', '=', 'sps.id')
			->whereIn('registrations.registration_number', $registration_number_list)
			->get();

		foreach ($participants as $key => $value) {
			$data = Registration_Result::where('registration_number', '=', $value['registration_number'])->first();

			if ($data != null) {
				Registration_Result::find($data->id)->update([
					'participant_id' => $value['participant_id'],
					'selection_path_id' => $value['selection_path_id'],
					'selection_path_name' => $value['selection_path_name'],
					'selection_program_name' => $value['selection_program_name'],
					'selection_program_id' => $value['selection_program_id'],
					'updated_by' => $this->by
				]);

				DB::connection('pgsql')->commit();
			}
		}
	}
}
