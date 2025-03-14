<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Passing_Grade extends Model {
    protected $connection = 'pgsql';
    protected $table = 'passing_grades';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'program_study_id',
        'mapping_path_year_id',
        'general_knowledge',
        'active_status',
        'created_by',
        'updated_by',
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
        'mapel11',
        'mapel12',
        'mapel13',
        'mapel14',
        'mapel15',
        'mapel16',
        'min_grade_value',
    ];

    public $timestamps = true;
}
?>