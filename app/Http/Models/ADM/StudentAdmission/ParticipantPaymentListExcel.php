<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;

use App\Http\Models\ADM\StudentAdmission\ExcelModel\Sheet2;

class ParticipantPaymentListExcel extends Model implements WithMultipleSheets {
    protected $connection = 'pgsql';
    protected $table = 'registrations';

    function __construct($program=null, $selection_path=null,$payment_status=null,$payment_method=null)
    {
        $this->program = $program;
        $this->selection_path = $selection_path;
        $this->payment_status = $payment_status;
        $this->payment_method = $payment_method;
    }

    public function sheets(): array
    {
        return [
            0 => new Sheet2($this->program, $this->selection_path, $this->payment_status, $this->payment_method)
        ];
    }
}
?>