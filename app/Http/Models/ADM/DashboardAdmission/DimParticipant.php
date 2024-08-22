<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimParticipant extends Model
{
    protected $table = 'dim_participants';
    protected $connection = 'datamart_dashboard';
    protected $primaryKey = 'participant_id';

    
}
