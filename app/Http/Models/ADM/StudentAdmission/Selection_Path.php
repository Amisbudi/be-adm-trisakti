<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selection_Path extends Model {
    protected $connection = 'pgsql';
    protected $table = 'selection_paths as sp';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'english_name',
        'name',
        'active_status',
    	'created_by',
    	'updated_by',
        'maks_program',
        'exam_status'
    ];
    public $timestamps = true;

    public static function GetSelectionPath(){
        $data = Selection_Path::select('sp.id','sp.name','sp.english_name','sp.start_date','sp.end_date','sp.maks_program', 'pr.name as program_name','sp.category_id')
        ->join('selection_programs as pr','sp.selection_program_id','=','pr.id')
        ->where('sp.active_status','=','1')
        ->get();
        return $data;
    }
}
?>