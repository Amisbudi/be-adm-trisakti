<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Question_Answer extends Model {
    protected $connection = 'pgsql';
    protected $table = 'question_answers';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'question_id',
        'answer_list',
        'participant_id',
    	'created_by',
    	'updated_by',
        'notes'
    ];
    public $timestamps = true;
    public static function ViewQuestionAnswer($question_id){
        $data = Question_Answer::select('id','answer_list','notes')
        ->where('question_id','=',$question_id)
        ->get();
        return $data;
    }
}
?>