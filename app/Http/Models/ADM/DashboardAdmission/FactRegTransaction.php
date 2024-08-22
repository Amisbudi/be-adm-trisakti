<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class FactRegTransaction extends Model
{
    protected $table = 'fact_reg_transaction';
    protected $connection = 'datamart_dashboard';
}
