<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Marriage_Status extends Model {
    protected $connection = 'masterdata';
    protected $table = 'marriage_status';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public static function getMarriageStatus($filter=''){

        if($filter != ''){
            $data = Marriage_Status::select('id','status')
            ->where('status','like','%'.$filter.'%')
            ->orderBy('status')
            ->get();

        } else{
            $data = Marriage_Status::select('id','status')
            ->orderBy('status')
            ->get();
        }
        return $data;
    }
}
?>