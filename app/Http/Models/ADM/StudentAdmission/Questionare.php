<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Questionare extends Model {
    protected $connection = 'pgsql';
    protected $table = 'quistionare';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'name',
        'description',
        'selection_path_id',
    	'created_by',
    	'updated_by',
        'active_status',
    ];
    public $timestamps = true;

}
?>