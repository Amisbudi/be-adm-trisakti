<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class District extends Model {
    protected $connection = 'masterdata';
    protected $table = 'districts';

    public static function GetDistrict($id='',$city_region_id=''){ 
        $filter=DB::raw('1');
        if($city_region_id){
            $city_region_id = ['city_region_id','=',$city_region_id];
        } else {
            $city_region_id = [$filter,'=',1];            
        }

        if($id){
            $id = ['id','=',$id];
        } else {
            $id = [$filter,'=',1];            
        }
            $data = District::select('id','city_region_id','detail_name')
            ->where([$id, $city_region_id])
            ->orderBy('id')
            ->get();
        return $data;
    }

    public static function GetDistrictName($id){ 
        $data = District::select('id','city_region_id','detail_name')
            ->where('id','=',$id)
            ->first();
        return $data;
    }
}
?>