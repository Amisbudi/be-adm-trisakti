<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Form extends Model {
    protected $connection = 'pgsql';
    protected $table = 'forms';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'name',
        'status',
    ];
}
?>