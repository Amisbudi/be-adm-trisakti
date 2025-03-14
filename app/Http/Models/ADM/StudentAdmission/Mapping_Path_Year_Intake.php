<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Year_Intake extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_year_intake';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'mapping_path_year_id',
        'semester',
        'school_year',
        'year',
    	'notes',
        'created_by',
        'updated_by',
        'nomor_reff',
        'active_status'
    ];

    public $timestamps = true;
}
?>