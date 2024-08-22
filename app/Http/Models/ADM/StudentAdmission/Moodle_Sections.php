<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Sections extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_sections';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'moodle_course_id',
        'name',
        'json_response',
        'created_by',
        'updated_by',
        'type'
    ];

    public $timestamps = true;
}
?>