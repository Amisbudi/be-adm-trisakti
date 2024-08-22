<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Moodle_Categories extends Model {
    protected $connection = 'pgsql';
    protected $table = 'moodle_categories';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'id',
        'name',
        'description',
        'selection_path_id',
    	'json_response',
        'created_by',
        'updated_by'
    ];

    public $timestamps = true;
}
?>