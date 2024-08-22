<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration_Steps extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registration_steps';
    protected $primaryKey = 'id';

    public static function GetRegistrationStep($name=''){
        if($name != ''){
            $data = Registration_Steps::select('id','step','description')
                    ->where('step','like','%'.$name.'%')
                    ->get();
        } else {
            $data = Registration_Steps::select('id','step','description')
                    ->get();
        }
        return $data;
    }

}
?>