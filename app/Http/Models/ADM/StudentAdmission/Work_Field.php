<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Work_Field extends Model {
    protected $connection = 'pgsql';
    protected $table = 'work_fields';
    protected $primaryKey = 'id';
    public $timestamps = true;

}
?>