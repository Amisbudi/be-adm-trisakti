<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pin_Voucher extends Model {
    protected $connection = 'pgsql';
    protected $table = 'pin_voucher as pv';

    protected $primaryKey = 'voucher';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [ 
        'study_program_id',
        'voucher',
        'type',
        'price',
        'description',
        'expire_date',
    	'created_by',
    	'updated_by',
        'active_status',
        'approved_by',
        'approved_at'
    ];
}
?>