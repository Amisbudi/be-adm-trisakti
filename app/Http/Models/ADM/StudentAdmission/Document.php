<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document extends Model {
    protected $connection = 'pgsql';
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_type_id',
        'name',
        'description',
        'number',
    	'created_by',
    	'updated_by',
        'url',
        'approval_final_status',
        'approval_final_date',
        'approval_final_by',
        'approval_final_comment'
    ];
    public $timestamps = true;

}
?>