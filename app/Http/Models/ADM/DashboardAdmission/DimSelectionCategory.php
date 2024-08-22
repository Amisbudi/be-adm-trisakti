<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimSelectionCategory extends Model
{
    protected $table = 'dim_selection_category';
    protected $connection = 'datamart_dashboard';
}
