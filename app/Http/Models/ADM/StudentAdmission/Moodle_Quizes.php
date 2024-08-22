<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Quizes extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_quizes';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'moodle_course_id',
        'moodle_section_id',
        'name',
        'description',
        'timeopen',
        'timeclose',
        'timelimit',
        'attempts',
        'attempt_closed',
        'mark_closed',
        'json_response',
        'created_by',
        'updated_by',
        'type'
    ];

    public $timestamps = true;
}
?>