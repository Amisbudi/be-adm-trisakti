<?php

namespace App\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;

class Transaction_Billing extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'transaction_billings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'registration_number',
        'school_year',
        'semester',
        'study_program_id',
        'specialization_id',
        'class_type_id',
        'spp_rank_id',
        'total_cost',
        'start_date_payment',
        'end_date_payment',
        'virtual_account',
        'trx_id',
        'json_response',
        'created_by',
        'updated_by'
    ];
}
