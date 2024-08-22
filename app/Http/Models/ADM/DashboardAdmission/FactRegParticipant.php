<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class FactRegParticipant extends Model
{
    protected $table = 'fact_reg_participants';
    protected $connection = 'datamart_dashboard';
}
