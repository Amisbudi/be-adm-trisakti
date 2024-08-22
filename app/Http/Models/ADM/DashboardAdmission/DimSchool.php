<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimSchool extends Model
{
    protected $table = 'dim_schools';
    protected $connection = 'datamart_dashboard';
}
