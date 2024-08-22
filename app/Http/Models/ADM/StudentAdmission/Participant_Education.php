<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant_Education extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participant_educations';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'participant_id',      
        'education_degree_id',
        'education_major_id',
    	'created_by',
    	'updated_by',
        'school_id',
        'graduate_year',
        'last_score',
        'student_id',
        'education_major',
        'school',
        'student_foreign',
        'city_id',
        'npsn',
        'npsn_he'
    ];
    public $timestamps = true;

}
?>