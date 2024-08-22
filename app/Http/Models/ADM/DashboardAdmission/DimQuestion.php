<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimQuestion extends Model
{
    protected $table = 'dim_questions';
    protected $connection = 'datamart_dashboard';
}
