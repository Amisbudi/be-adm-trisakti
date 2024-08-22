<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class Moodle_Courses extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_courses';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'category_id',
        'shortname',
        'fullname',
    	'selection_path_id',
        'summary',
        'startdate',
        'enddate',
        'image',
        'group_mode',
        'group_mode_force',
        'enable_completion',
        'json_response',
        'created_by',
        'updated_by',
        'path_exam_detail_id'
    ];

    public $timestamps = true;

    //function for get next increment id from moodle_courses
    public static function GetNextAutoIncrementMoodleCourse()
    {
        $data = DB::connection("pgsql")->select("SELECT nextval('moodle_courses_id_seq'::regclass)");
        return $data[0]->nextval;
    }
}
?>