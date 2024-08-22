<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class New_Student_Step extends Model {
    protected $connection = 'pgsql';
    protected $table = 'new_student_step';
    protected $primaryKey = 'id';
}
?>