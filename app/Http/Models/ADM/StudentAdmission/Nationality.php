<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Nationality extends Model {
    protected $connection = 'masterdata';
    protected $table = 'nationalities';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public static function getNationality($filter=''){

        if($filter != ''){
            $data = Nationality::select('id','nationality')
            ->where('nationality','like','%'.$filter.'%')
            ->orderBy('nationality')
            ->get();

        } else{
            $data = Nationality::select('id','nationality')
            ->orderBy('nationality')
            ->get();
        }
        return $data;
    }

    public static function getNationalityName($id) {
        $data = Nationality::select('id','nationality')
            ->where('id','=',$id)
            ->first();
        
        return $data;
    }
}
?>