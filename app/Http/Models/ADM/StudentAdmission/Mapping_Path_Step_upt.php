<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Step_upt extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_step';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'registration_step_id',
        'selection_path_id',
        'ordering',
    	'created_by',
    	'updated_by',
        'active_status',
    ];
    public $timestamps = true;

}
?>