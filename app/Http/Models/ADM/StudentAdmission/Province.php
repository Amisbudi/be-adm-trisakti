<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Province extends Model {
    protected $connection = 'masterdata';
    protected $table = 'provinces';

    public static function GetProvince($id='',$country_id=''){
         $filter=DB::raw('1');
        if($country_id){
            $country_id = ['country_id','=',$country_id];
        } else {
            $country_id = [$filter,'=',1];            
        }

        if($id){
            $id = ['id','=',$id];
        } else {
            $id = [$filter,'=',1];            
        }

            $data = Province::select('id','detail_name','country_id')
            ->where([$country_id, $id])
            ->orderBy('id')
            ->get();
        return $data;
    }

    public static function GetProvinceName($id) {
        $data = Province::select('id','detail_name')
            ->where('id','=',$id)
            ->first();
        return $data;
    }
}
?>