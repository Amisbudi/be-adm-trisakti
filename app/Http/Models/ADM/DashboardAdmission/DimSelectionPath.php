<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimSelectionPath extends Model
{
    protected $table = 'dim_selection_paths';
    protected $connection = 'datamart_dashboard';
}
