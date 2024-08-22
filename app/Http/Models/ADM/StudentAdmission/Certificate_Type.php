<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Certificate_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'certificate_type';

    public static function GetCertificateType(){
            $data = Certificate_Type::select('id','type','description')
            ->where('active_status', '=', true)
            ->orderBy('id','asc')
            ->get();
        return $data;
    }
}
?>