<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant_Work_Data extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participant_work_data';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'participant_id',
        'work_field_id',
        'company_name',
        'work_position',
        'work_start_date',
        'work_end_date',
        'company_address',
        'company_phone_number',
    	'created_by',
    	'updated_by',
        'work_type_id',
        'work_income_range_id'
    ];
    public $timestamps = true;

}
?>