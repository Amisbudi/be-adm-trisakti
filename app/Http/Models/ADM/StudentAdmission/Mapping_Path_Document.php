<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Document extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_documents as md';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_type_id',
        'selection_path_id',
    	'created_by',
    	'updated_by',
        'program_study_id',
        'active_status',
        'required',
        'is_value'
    ];
    public $timestamps = true;

}
?>