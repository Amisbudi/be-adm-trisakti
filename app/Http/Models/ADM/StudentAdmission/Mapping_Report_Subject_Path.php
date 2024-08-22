<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Report_Subject_Path extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_report_subject_path';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'is_technic',
        'math',
    	'physics',
        'biology',
        'chemical',
        'bahasa',
        'english',
        'economy',
        'geography',
        'sociological',
        'historical',
        'created_by',
        'updated_by',
        'active_status'
    ];

    public $timestamps = true;
}
?>