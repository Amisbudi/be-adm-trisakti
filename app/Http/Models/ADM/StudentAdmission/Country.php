<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model {
    protected $connection = 'masterdata';
    protected $table = 'countries';

    public static function GetCountry($id=''){
        if($id != ''){
            $data = Country::select('id','detail_name','code')
            ->where('id','=',$id)
            ->orderBy('id')
            ->get();
        } else {
            $data = Country::select('id','detail_name','code')
            ->orderBy('id')
            ->get();
        }
        return $data;
    }

    public static function GetCountryName($id) {
        $data = Country::select('id','detail_name','code')
            ->where('id','=',$id)
            ->first();
        return $data;
    }
}
?>