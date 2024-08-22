<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Session_Study_Program extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_session_study_program';
    protected $primaryKey = 'id';

    protected $fillable = [
        'program_study_id',
        'program_study',
        'faculty_id',
        'faculty'
    ];
}
