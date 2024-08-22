<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class FactRegPaidTransaction extends Model
{
    protected $table = 'fact_reg_paid_transaction';
    protected $connection = 'datamart_dashboard';
}
