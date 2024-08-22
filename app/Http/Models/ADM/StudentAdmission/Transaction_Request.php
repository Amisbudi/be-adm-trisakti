<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;

class Transaction_Request extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'transaction_request';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'trx_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'virtual_account',
        'trx_id',
        'datetime_expired',
        'description',
        'type',
        'prefix',
        'data',
        'ipfy',
        'ip',
        'ip_remote',
        'name_remote',
        'json_response',
        'created_by',
        'updated_by',
        'registration_number'
    ];

    protected $casts = [
        'trx_amount' => 'float',
    ];
}
