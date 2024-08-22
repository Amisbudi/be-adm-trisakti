<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant_Family extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participant_families';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'participant_id',
        'family_relationship_id',
        'family_name',
        'email',
        'mobile_phone_number',
        'birth_place',
        'birth_date',
        'gender',
        'education_degree_id',
        'work_status',
        'work_position',
        'work_income_range_id',
        'address_country',
        'address_province',
        'address_city',
        'address_disctrict',
        'address_detail',
        'address_postal_code',
    	'created_by',
    	'updated_by',
        'work_field_id',
        'work_type_id',
        'company_name',
        'identify_number',
        'active_status'
    ];
    public $timestamps = true;

}
?>