<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Range_Score extends Model {
    protected $connection = 'pgsql';
    protected $table = 'range_scores';
    protected $primaryKey = 'id';

    public static function GetRangeScore(){
            $data = Range_Score::select('id','name')
                    ->orderBy('id','asc')
                    ->get();
        return $data;
    }

}
?>