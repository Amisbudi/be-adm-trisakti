<?php

namespace app\Http\Models\ADM\StudentAdmission;

use App\Http\Models\ADM\StudentAdmission\ExcelModel\Sheet4;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Database\Eloquent\Model;

class MappingRegistrationProgramStudyListExcel extends Model implements WithMultipleSheets  {
    protected $connection = 'pgsql';
    protected $table = 'mapping_registration_program_study';
    protected $primaryKey = 'id';

    function __construct($selection_path = null)
    {
        $this->selection_path = $selection_path;
    }

    public function sheets(): array
    {
	    return [0 => new Sheet4($this->selection_path)];
    }
}
