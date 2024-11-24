<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Utbk_Path extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_utbk_path';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'is_science',
        'mapel1',
        'mapel2',
        'mapel3',
        'mapel4',
        'mapel5',
        'mapel6',
        'mapel7',
        'mapel8',
        'mapel9',
        'mapel10',
        'created_by',
        'updated_by',
        'active_status'
    ];

    public $timestamps = true;
}
?>