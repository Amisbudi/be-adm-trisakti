<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimExamStatus extends Model
{
    protected $table = 'dim_pass_status';
    protected $connection = 'datamart_dashboard';
}
