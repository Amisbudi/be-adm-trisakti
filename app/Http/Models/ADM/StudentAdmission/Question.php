<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Question extends Model {
    protected $connection = 'pgsql';
    protected $table = 'questions';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'questionare_id',
        'question_type_id',
        'detail',
    	'created_by',
    	'updated_by',
        'active_status',
    ];
    public $timestamps = true;

}
?>