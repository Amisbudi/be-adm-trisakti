<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment_Method extends Model {
    protected $connection = 'pgsql';
    protected $table = 'payment_methods';
    public $timestamps = true;
}
?>