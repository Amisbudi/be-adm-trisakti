<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Faculty extends Model {
    protected $connection = 'masterdata';
    protected $table = 'faculties';
    protected $primaryKey = 'id';
    public $timestamps = true;
}
?>