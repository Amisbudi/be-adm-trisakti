<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration_Result extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registration_result';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'registration_number',      
        'total_score',
        'pass_status',
    	'created_by',
    	'updated_by',
        'publication_status',
        'publication_date',
        'participant_id',
        'selection_path_id',
        'program_study_id',
        'schoolarship_id',
        'up3',
        'bpp',
        'sdp2',
        'dormitory',
        'up3discount',
        'bppdiscount',
        'sdp2discount',
        'dormitorydiscount',
        'semester',
        'insurance',
        'notes',
        'start_date_1',
        'start_date_2',
        'start_date_3',
        'end_date_1',
        'end_date_2',
        'end_date_3',
        'schoolyear',
        'type',
        'oldstudentid',
        'reference_number',
        'password',
        'transfer_status',
        'transfer_program_study_id',
        'council_date',
        'approval_university',
        'approval_university_by',
        'approval_university_at',
        'generated_at',
        'file_url',
        'specialization_id'
    ];
    
    public $timestamps = true;

}
?>