<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Study_Program_Specialization extends Model {
    protected $connection = 'pgsql';
    protected $table = 'study_program_specializations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'specialization_name_ori ',
        'specialization_name',
        'specialization_code',
        'active_status',
        'class_type',
        'program_study_id',
        'faculty_id',
        'faculty_name',
        'category',
        'classification_name',
        'study_program_name',
        'study_program_name_en',
        'acronim'
    ];
    public $timestamps = true;

}
?>