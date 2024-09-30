<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Schedule extends Model {
    protected $connection = 'pgsql';
    protected $table = 'schedules';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'selection_path_id',
        'category_id',
        'session',
        'date',
        'status',
    ];
}
?>