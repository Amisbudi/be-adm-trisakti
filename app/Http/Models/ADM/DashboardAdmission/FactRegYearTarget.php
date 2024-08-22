<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class FactRegYearTarget extends Model
{
    protected $table = 'fact_reg_year_target';
    protected $connection = 'datamart_dashboard';

    public $timestamps = false;
}
