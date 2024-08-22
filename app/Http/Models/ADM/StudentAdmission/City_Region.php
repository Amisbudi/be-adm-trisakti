<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class City_Region extends Model {
    protected $connection = 'masterdata';
    protected $table = 'city_regions';

    public static function GetCity($id='', $province_id='') {  
        $filter=DB::raw('1');
        if($province_id){
            $province_id = ['province_id','=',$province_id];
        } else {
            $province_id = [$filter,'=',1];            
        }

        if($id){
            $id = ['id','=',$id];
        } else {
            $id = [$filter,'=',1];            
        }

            $data = City_Region::select('id','detail_name as city','province_id')
            ->where([$province_id, $id])
            ->orderBy('detail_name')
            ->get();
        return $data;
    }

    public static function GetCityName($id) {  
        $data = City_Region::select('id','detail_name as city')
            ->where('id','=',$id)
            ->first();

        return $data;
    }
}
?>