<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimSchoolYear extends Model
{
    protected $table = 'dim_school_year';
    protected $connection = 'datamart_dashboard';

    public $timestamps = false;
}
