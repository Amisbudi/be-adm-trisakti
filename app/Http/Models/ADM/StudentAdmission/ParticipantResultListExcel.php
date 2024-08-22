<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

use App\Http\Models\ADM\StudentAdmission\ExcelModel\Sheet3;

class ParticipantResultListExcel extends Model implements WithMultipleSheets {
    protected $connection = 'pgsql';
    protected $table = 'registrations';

    function __construct($program=null, $selection_path=null, $registration_number=null)
    {
        $this->program = $program;
        $this->selection_path = $selection_path;
        $this->registration_number = $registration_number;
    }

    public function sheets(): array
    {
	    return [
			         0 => new Sheet3($this->program, $this->selection_path, $this->registration_number)
					];
    }
}
?>