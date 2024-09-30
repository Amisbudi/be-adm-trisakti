<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Price extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_price as mpp';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'price',
        'selection_path_id',
    	'created_by',
    	'updated_by',
        'active_status',
        'maks_study_program',
        'mapping_path_year_id',
        'study_program_id',
        'form_id',
        'category',
        'is_medical'
    ];
    public $timestamps = true;
}
?>