<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration_History extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registration_history';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'registration_number',
        'registration_step_id',
    	'created_by',
    	'updated_by',
    ];
    public $timestamps = true;
    
}
?>