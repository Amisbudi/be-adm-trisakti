<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment_Status extends Model {
    protected $connection = 'pgsql';
    protected $table = 'payment_status';
    public $timestamps = true;

    public static function GetPaymentStatus(){
        $data = Payment_Status::select('id','status')
        	->where('active_status','=','t')
            ->get();
        return $data;
    }

}
?>