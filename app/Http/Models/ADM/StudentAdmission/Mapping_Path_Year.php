<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Year extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_year';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'year',
        'school_year',
    	'active_status',
        'created_by',
        'updated_by',
        'start_date',
        'end_date'
    ];

    public $timestamps = true;
}
?>