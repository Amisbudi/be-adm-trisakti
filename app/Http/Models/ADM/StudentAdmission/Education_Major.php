<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Education_Major extends Model {
    protected $connection = 'pgsql';
    protected $table = 'education_majors';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'major'
    ];
    public $timestamps = true;

    public static function getEducationMajor($filter=''){

        if($filter != ''){
            $data = Education_Major::select('id','major','is_technic')
            ->where('id','=',$filter)
            ->orderBy('id','asc')
            ->get();

        } else{
            $data = Education_Major::select('id','major','is_technic')
            ->orderBy('id','asc')
            ->get();
        }
        return $data;
    }

}
?>