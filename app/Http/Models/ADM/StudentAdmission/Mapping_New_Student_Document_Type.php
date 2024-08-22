<?php

namespace App\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_New_Student_Document_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_new_student_document_path';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'new_student_document_type_id'
    ];

    public $timestamps = true;
}
?>