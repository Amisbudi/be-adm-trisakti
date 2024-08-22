<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Location_Exam extends Model {
    protected $connection = 'pgsql';
    protected $table = 'location_exam';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'city',
        'location',
        'address',
        'active_status',
    	'created_by',
    	'updated_by'
    ];
    public $timestamps = true;

    public static function getLocationExam($filter='',$active_status=''){
        
        $test = DB::raw('1');

        $subquery = '(select id, city from
                dblink( '."'admission_masterdata'".','."'select id, detail_name as city from masterdata.public.city_regions') AS t1 ( id int, city varchar )) as ct";
        if($active_status != ''){
            $active_status = ['active_status','=',$active_status];
        } else {
            $active_status = [$test,'=',1];  
        }
        if($filter != ''){
            $filter = ['ct.id','=',$filter];
        } else {
            $filter = [$test,'=',1];  
        }
            $data = Location_Exam::select('location_exam.id','location','address','active_status','ct.city','ct.id as city_id',DB::raw('case when active_status ='."'t'".' then '."'Aktif'".' else '."'Non Aktif'".' end as active_status_name'))
            ->join(DB::raw($subquery), 
                function($join)
                {
                   $join->on('location_exam.city', '=', 'ct.id');
                })
            ->where([$active_status, $filter])
            ->orderBy('location_exam.id','desc')
            ->get();

        return $data;
    }
}
?>