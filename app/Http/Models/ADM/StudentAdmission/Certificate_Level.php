<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Certificate_Level extends Model {
    protected $connection = 'pgsql';
    protected $table = 'certificate_levels';

    public static function GetCertificateLevel(){
            $data = Certificate_Level::select('id','type','description')
            ->orderBy('id','asc')
            ->get();
        return $data;
    }
}
?>