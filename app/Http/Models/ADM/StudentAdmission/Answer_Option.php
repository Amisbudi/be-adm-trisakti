<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Answer_Option extends Model {
    protected $connection = 'pgsql';
    protected $table = 'answer_options';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'question_id',
        'value',
        'ordering',
    	'created_by',
    	'updated_by',
    ];
    public $timestamps = true;
    public static function ViewListAnswer($question_id){
        $data = Answer_Option::select('id','question_id','value','ordering')
        ->where('question_id','=',$question_id)
        ->orderBy('ordering','asc')
        ->get();
        return $data;
    }
}
?>