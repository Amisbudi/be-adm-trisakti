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
        'math',
        'english',
    	'physics',
        'chemical',
        'biology',
        'drawing',
        'photography_knowledge',
        'created_by',
        'updated_by',
        'active_status',
        'min_grade_value',
        'bahasa',
        'economy',
        'geography',
        'sociological',
        'historical',
        'tpa'
    ];

    public $timestamps = true;
}
?>