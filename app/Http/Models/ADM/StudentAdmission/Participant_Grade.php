<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant_Grade extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participant_grades';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'registration_number',
        'mapel1',
        'mapel2',
        'mapel3',
        'mapel4',
        'mapel5',
        'mapel6',
        'mapel7',
        'mapel8',
        'mapel9',
        'mapel10',
        'mapel11',
        'mapel12',
        'created_by',
        'updated_by',
        'grade_final',
        'approval_faculty',
        'approval_faculty_by',
        'approval_faculty_at',
        'mapel13',
        'mapel14',
        'mapel15',
        'mapel16',
    ];

    public $timestamps = true;
}
?>