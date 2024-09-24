<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Exam_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'exam_type';
    protected $fillable = ['id','name', 'active_status'];

    public static function GetExamType(){
        $data = Exam_Type::select('id','name','active_status')
            ->orderBy('id','asc')
            ->get();

        return $data;
    }

    public static function getExamTypeName($id) {
        $data = Exam_Type::select('name')
            ->where('id','=',$id)
            ->first();
        
        return $data;
    }
}
?>