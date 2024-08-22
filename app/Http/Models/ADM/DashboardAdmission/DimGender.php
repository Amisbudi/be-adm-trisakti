<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimGender extends Model
{
    protected $table = 'dim_gender';
    protected $connection = 'datamart_dashboard';
}
