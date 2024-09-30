<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Study_Program extends Model {
    protected $connection = 'pgsql';
    protected $table = 'study_programs';
    protected $primaryKey = 'classification_id';
    protected $fillable = [
        'program_study_id',
        'faculty_id',
        'category',
        'classification_name',
        'study_program_branding_name',
        'study_program_name',
        'study_program_name_en',
        'study_program_acronim',
        'faculty_name',
        'acronim',
        'acreditation',
        'quota'
    ];
    public $timestamps = false;
}
?>