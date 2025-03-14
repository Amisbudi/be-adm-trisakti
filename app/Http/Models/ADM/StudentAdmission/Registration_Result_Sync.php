<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration_Result_Sync extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registration_result_sync';
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
        'spp',
        'bpp',
        'lainnya',
        'ujian',
        'praktikum',
        'bppdiscount',
        'sppdiscount',
        'discount',
        'semester',
        'sks',
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
        'faculty_number',
        'password',
        'transfer_status',
        'transfer_program_study_id',
        'council_date',
        'approval_university',
        'approval_university_by',
        'approval_university_at',
        'generated_at',
        'file_url',
        'specialization_id',
        'package_id',
        'payment_method_id',
        'payment_status',
        'total_amount',
    ];
    
    public $timestamps = true;

}
?>