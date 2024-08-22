<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gender extends Model {
    protected $connection = 'masterdata';
    protected $table = 'gender';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public static function getGender($filter=''){

        if($filter != ''){
            $data = Gender::select('id','gender')
            ->where('gender','like','%'.$filter.'%')
            ->orderBy('gender')
            ->get();

        } else{
            $data = Gender::select('id','gender')
            ->orderBy('gender')
            ->get();
        }
        return $data;
    }

    public static function getGenderName($id) {
        $data = Gender::select('gender')
            ->where('id','=',$id)
            ->first();
        
        return $data;
    }
}
