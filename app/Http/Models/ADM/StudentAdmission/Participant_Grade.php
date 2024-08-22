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
        'math',
        'physics',
        'bahasa',
        'english',
        'biology',
        'economy',
        'geography',
        'sociological',
        'historical',
        'chemical',
        'general_knowledge',
        'photography_knowledge',
        'tpa',
        'created_by',
        'updated_by',
        'grade_final',
        'approval_faculty',
        'approval_faculty_by',
        'approval_faculty_at',
        'interview_test',
        'psychological_test',
        'drawing_test'
    ];

    public $timestamps = true;
}
?>