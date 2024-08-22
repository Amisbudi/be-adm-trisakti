<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Members extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_members';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'moodle_group_id',
        'moodle_user_id',
        'json_response',
        'created_by',
        'updated_by',
        'moodle_course_id'
    ];

    public $timestamps = true;
}
?>