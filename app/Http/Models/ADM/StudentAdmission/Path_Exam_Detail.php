<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Path_Exam_Detail extends Model {
    protected $connection = 'pgsql';
    protected $table = 'path_exam_details';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'selection_path_id',
        'exam_start_date',
        'exam_end_date',
        'active_status',
    	'updated_by',
        'created_by',
        'exam_location_id',
        'quota',
        'session_one_start',
        'session_two_start',
        'session_three_start',
        'session_one_end',
        'session_two_end',
        'session_three_end',
        'exam_type_id'
    ];
    public $timestamps = true;

}
?>