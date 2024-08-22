<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Education_Degree extends Model {
    protected $connection = 'pgsql';
    protected $table = 'education_degrees';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'level',      
        'description',
    ];
    public $timestamps = true;

    public static function getEducationDegree($filter=''){

        if($filter != ''){
            $data = Education_Degree::select('id','level','description','type')
            ->where('level','like','%'.$filter.'%')
            ->orderBy('level')
            ->get();

        } else{
            $data = Education_Degree::select('id','level','description','type')
            ->orderBy('level')
            ->get();
        }
        return $data;
    }
}
?>