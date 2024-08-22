<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;

class Transaction_Voucher extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'transaction_voucher';
    protected $primaryKey = 'id';

    protected $fillable = [
        'voucher',
        'registration_number',
        'created_by',
        'updated_by'
    ];
}
