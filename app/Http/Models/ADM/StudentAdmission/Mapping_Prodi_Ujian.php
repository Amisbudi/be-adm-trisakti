<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Ujian extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_ujian';
    protected $primaryKey = 'id';
    protected $fillable = [
        'study_program_id',
        'exam_type_id',
        'status'
    ];
    public $timestamps = false;
}
