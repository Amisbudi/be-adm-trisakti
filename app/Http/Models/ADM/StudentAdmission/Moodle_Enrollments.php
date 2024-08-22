<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Enrollments extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_enrollments';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'moodle_user_id',
        'moodle_course_id',
        'role_id',
        'timestart',
        'timeend',
        'moodle_group_id',
        'json_response',
        'created_by',
        'updated_by'
    ];

    public $timestamps = true;
}
?>