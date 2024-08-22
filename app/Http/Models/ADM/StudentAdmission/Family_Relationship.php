<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Family_Relationship extends Model {
    protected $connection = 'pgsql';
    protected $table = 'family_relationship';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public static function getFamilyRelationship($filter=''){

        if($filter != ''){
            $data = Family_Relationship::select('id','relationship','category')
            ->where('category','=',$filter)
            ->orderBy('id')
            ->get();

        } else{
            $data = Family_Relationship::select('id','relationship','category')
            ->orderBy('id')
            ->get();
        }
        return $data;
    }
}
?>