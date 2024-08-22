<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimExamLocation extends Model
{
    protected $table = 'dim_exam_locations';
    protected $connection = 'datamart_dashboard';
}
