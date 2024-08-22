<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Exception;
use Illuminate\Database\Eloquent\Model;

class DimStudyProgram extends Model
{
    protected $table = 'dim_studyprograms';
    protected $connection = 'datamart_dashboard';
}
