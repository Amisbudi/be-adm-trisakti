<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimFaculty extends Model
{
    protected $table = 'dim_faculties';
    protected $connection = 'datamart_dashboard';
}
