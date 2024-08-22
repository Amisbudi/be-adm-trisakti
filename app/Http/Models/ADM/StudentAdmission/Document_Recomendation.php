<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Recomendation extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_recomendation';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_id',
        'registration_number',
        'name',
        'handphone',
        'email',
        'position',
        'institution',
        'long_capacity_knowing_student',
        'knowledge',
        'intellectual',
        'verbal_expression',
        'written_expression',
        'work_independently',
        'work_cooperate',
        'maturity',
        'recomendation',
        'opinion',
        'ip_address',
        'token'
    ];
    
    public $timestamps = true;

}
?>