<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Semester extends Model {
    protected $connection = 'pgsql';
    protected $table = 'semesters';
    protected $primaryKey = 'id';

    public static function GetSemester(){
            $data = Semester::select('id','name')
                    ->orderBy('id','asc')
                    ->get();
        return $data;
    }

}
?>