<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Study extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_study';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'document_id',
        'score',
    	'created_by',
    	'updated_by',
        'registration_number',
        'year',
        'title'
    ];
}
?>