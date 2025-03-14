<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Change_Program extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'change_programs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'registration_number',
        'study_programs_id_ex',
        'study_programs_id',
        'approval_fakultas',
        'approval_fakultas_by',
        'approval_fakultas_date',
        'approval_universitas',
        'approval_universitas_by',
        'approval_universitas_date',
    ];

    public $timestamps = true;
}
