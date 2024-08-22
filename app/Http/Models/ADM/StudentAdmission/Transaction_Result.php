<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;

class Transaction_Result extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'transaction_result';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'trx_id',
        'type',
        'prefix',
        'data',
        'ipfy',
        'ip',
        'ip_remote',
        'name_remote',
        'virtual_account',
        'trx_amount',
        'customer_name',
        'customer_email',
        'customer_phone',
        'datetime_created',
        'datetime_expired',
        'datetime_payment',
        'datetime_last_updated',
        'payment_ntb',
        'payment_amount',
        'va_status',
        'description',
        'billing_type',
        'datetime_created_iso8601',
        'datetime_expired_iso8601',
        'datetime_payment_iso8601',
        'datetime_last_updated_iso8601',
        'json_response',
        'created_by',
        'updated_by',
        'registration_number'
    ];
}
