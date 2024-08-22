<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Work_Income_Range extends Model {
    protected $connection = 'pgsql';
    protected $table = 'work_income_range';
    protected $primaryKey = 'id';
    public $timestamps = true;

}
?>