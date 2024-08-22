<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class New_Student extends Model {
    protected $connection = 'pgsql';
    protected $table = 'new_student';
    protected $primaryKey = 'id';

    protected $fillable = [
        'registration_number',
        'program_study_id',
        'email',
        'password',
        'student_id',
        'participant_id',
        'created_by',
        'updated_by'
    ];
}
?>