<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Study_Program extends Model {
    protected $connection = 'pgsql';
    protected $table = 'study_programs';
    protected $primaryKey = 'classification_id';
    public $timestamps = true;

}
?>