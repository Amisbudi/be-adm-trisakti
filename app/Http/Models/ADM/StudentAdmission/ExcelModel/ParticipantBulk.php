<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use App\Http\Models\ADM\StudentAdmission\Framework_Mapping_User_Role;
use App\Http\Models\ADM\StudentAdmission\Framework_User;
use App\Http\Models\ADM\StudentAdmission\Participant;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ParticipantBulk extends Model implements ToCollection
{
	function __construct($by = null)
	{
		$this->by = $by;
	}

	public function collection(Collection $rows)
	{
		$count = 0;

		//temporary data
		$participants = array();

		foreach ($rows as $row) {
			//disable first row, Heading Row
			if ($count == 0) {
				$count++;
				continue;
			}

			array_push($participants, [
				'username' => $row[0],
				'fullname' => $row[1],
				'password' => bcrypt($row[2]),
				'gender' => $row[3],
				'mobile_phone_number' => $row[4],
				'birth_date' => ($row[5] == null) ? null : $row[5],
				'address_detail' => $row[6],
				'address_postal_code' => $row[7],
				'color_blind' => $row[8],
				'special_needs' => $row[9]
			]);
		}

		foreach ($participants as $key => $value) {

			Framework_User::updateOrCreate([
				'id' => 'admisi-' . $value['username']
			],
			[
				'id' => 'admisi-' . $value['username'],
				'email' => $value['username']
			]);

			Framework_Mapping_User_Role::updateOrCreate([
				'user_id' => 'admisi-' . $value['username']
			],
			[
				'user_id' => 'admisi-' . $value['username'],
				'oauth_role_id' => env('OAUTH_ID'),
				'created_by' => $this->by
			]);
			Participant::updateOrCreate([
				'username' => $value['username']
			],
			[
				'username' => $value['username'],
				'fullname' => $value['fullname'],
				'mobile_phone_number' => $value['mobile_phone_number'],
				'password' => $value['password'],
				'gender' => $value['gender'],
				'birth_date' => $value['birth_date'],
				'address_detail' => $value['address_detail'],
				'address_postal_code' => $value['address_postal_code'],
				'created_by' => $this->by,
				'isverification' => '1',
			]);
		}
	}
}
