<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

use App\Http\Models\ADM\StudentAdmission\ExcelModel\Sheet1;

class ParticipantListExcel extends Model implements WithMultipleSheets {
    protected $connection = 'pgsql';
    protected $table = 'registrations';

    function __construct($start_date=null, $end_date=null, $program=null, $selection_path=null,$nationality=null)
    {
        $this->program = $program;
        $this->selection_path = $selection_path;
		$this->nationality = $nationality;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
        
    }

    public function sheets(): array
    {
	    return [0 => new Sheet1($this->start_date, $this->end_date, $this->program, $this->selection_path, $this->nationality)];
    }
}
?>