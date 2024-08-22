<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pin_Voucher extends Model {
    protected $connection = 'pgsql';
    protected $table = 'pin_voucher';

    protected $primaryKey = 'voucher';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [ 
        'voucher',
        'type',
        'price',
        'expire_date',
    	'created_by',
    	'updated_by',
        'active_status',
    ];
}
?>