<?php

namespace app\Http\Models\ADM\StudentAdmission;

use App\Http\Models\ADM\StudentAdmission\ExcelModel\ParticipantRegistrationData;
use App\Http\Models\ADM\StudentAdmission\ExcelModel\ParticipantReportCard;
use App\Http\Models\ADM\StudentAdmission\ExcelModel\ParticipantCertificate;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Database\Eloquent\Model;

class ParticipantRegistrationExcel extends Model implements WithMultipleSheets  {
    protected $connection = 'pgsql';
    protected $table = 'registrations';
    protected $primaryKey = 'id';

    function __construct($selection_path = null, $mapping_path_year_id = null)
    {
        $this->selection_path = $selection_path;
        $this->mapping_path_year_id = $mapping_path_year_id;
    }

    public function sheets(): array
    {
	    return [
            0 => new ParticipantRegistrationData($this->selection_path, $this->mapping_path_year_id),
            1 => new ParticipantReportCard($this->selection_path, $this->mapping_path_year_id)
            // 2 => new ParticipantCertificate($this->selection_path, $this->mapping_path_year_id)
        ];
    }
}
