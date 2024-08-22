<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Registration_Program_Study extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_registration_program_study';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [ 
        'registration_number',
        'mapping_path_study_program_id',
    	'created_by',
    	'updated_by',
        'priority',
        'education_fund',
        'program_study_id',
        'study_program_specialization_id',
        'approval_faculty',
        'approval_faculty_at',
        'approval_faculty_by',
        'rank'
    ];
}
