<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_New_Student_Step extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_new_student_step';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'new_student_id',
        'new_student_step_id'
    ];

    public $timestamps = true;
}
?>