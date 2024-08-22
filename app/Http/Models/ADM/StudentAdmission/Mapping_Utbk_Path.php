<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Utbk_Path extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_utbk_path';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'is_science',
        'math',
    	'physics',
        'biology',
        'chemical',
        'economy',
        'geography',
        'sociological',
        'created_by',
        'updated_by',
        'historical',
        'active_status'
    ];

    public $timestamps = true;
}
?>