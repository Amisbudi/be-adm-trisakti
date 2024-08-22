<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class School extends Model {
    protected $connection = 'pgsql';
    protected $table = 'schools';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'name',      
        'address',
        'npsn',
    	'city_region_id',
    	'is_validated',
    ];
    public $timestamps = true;

    public static function getSchool($filter=''){

        if($filter != ''){
            $data = School::select('id','name','address','npsn','city_region_id')
            ->where('city_region_id','=',$filter)
            ->orderBy('id')
            ->get();

        } else{
            $data = School::select('id','name','address','npsn')
            ->orderBy('id')
            ->get();
        }
        return $data;
    }

}
?>