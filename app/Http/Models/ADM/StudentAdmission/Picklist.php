<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Picklist extends Model {
    protected $connection = 'pgsql';
    protected $table = 'picklist';
    public $timestamps = true;

    public static function getPickList($pick_name=''){
        
        $test = DB::raw('1');

        if($pick_name != ''){
            $pick_name = ['pick_name','=',$pick_name];
        } else {
            $pick_name = [$test,'=',1];  
        }
        
        $data = Picklist::select('id','pick_name','pick_value','pick_label')
            ->where([$pick_name])
            ->orderBy('id','asc')
            ->get();

        return $data;
    }
}
?>