<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Location_Selection extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_location_selection';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'selection_path_id',
        'location_exam_id',
        'active_status',
    	'created_by',
    	'updated_by'
    ];
    public $timestamps = true;

}
?>