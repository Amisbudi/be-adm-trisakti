<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Study_Program_Specialization extends Model {
    protected $connection = 'pgsql';
    protected $table = 'study_program_specializations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'classification_id',
        'specialization_name',
        'specialization_code',
        'active_status',
        'class_type',
        'class_type_id',
    ];
    public $timestamps = true;

}
?>