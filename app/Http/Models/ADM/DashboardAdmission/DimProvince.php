<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimProvince extends Model
{
    protected $table = 'dim_provinces';
    protected $connection = 'datamart_dashboard';
}
