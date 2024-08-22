<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;

class DimListOfInvoiceItem extends Model
{
    protected $table = 'dim_listofinvoiceitem';
    protected $connection = 'datamart_dashboard';
}
