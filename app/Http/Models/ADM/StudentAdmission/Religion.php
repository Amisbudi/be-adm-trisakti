<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Religion extends Model {
    protected $connection = 'masterdata';
    protected $table = 'religions';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'religion',
    	'created_by',
    	'updated_by'
    ];
    public $timestamps = true;

    public static function getReligion($filter=''){

        if($filter != ''){
            $data = Religion::select('id','religion')
            ->where('religion','like','%'.$filter.'%')
            ->orderBy('religion')
            ->get();

        } else{
            $data = Religion::select('id','religion')
            ->orderBy('religion')
            ->get();
        }
        return $data;
    }

    public static function getReligionName($id) {

        $data = Religion::select('religion')
            ->where('id','=',$id)
            ->first();

        return $data;
    }
}
?>