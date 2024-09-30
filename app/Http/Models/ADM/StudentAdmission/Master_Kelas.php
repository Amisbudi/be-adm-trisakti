<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Master_kelas extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'study_program_specializations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'classification_id',
        'specialization_name',
        'specialization_code',
        'active_status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'class_type',
        'class_type_id',
    ];
    public $timestamps = true;
}
