<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Program extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_program';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'selection_program_id',
        'selection_path_id',
        'start_date',
    	'end_date',
    	'updated_by',
        'created_by',
    ];
    public $timestamps = true;

}
?>