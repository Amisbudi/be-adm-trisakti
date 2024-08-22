<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Groups extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_groups';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'moodle_course_id',
        'name',
        'description',
        'starttime',
        'sections',
        'json_response',
        'created_by',
        'updated_by',
        'exam_group_id'
    ];

    public $timestamps = true;

    //function for get next increment id from moodle_courses
    public static function GetNextAutoIncrementMoodleCourse()
    {
        $data = DB::connection("pgsql")->select("SELECT nextval('moodle_groups_id_seq'::regclass)");
        return $data[0]->nextval;
    }
}
?>