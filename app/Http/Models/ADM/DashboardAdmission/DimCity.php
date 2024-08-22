<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimCity extends Model
{
    protected $table = 'dim_cities';
    protected $connection = 'datamart_dashboard';
}
