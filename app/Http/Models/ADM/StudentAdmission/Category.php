<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model {
    protected $connection = 'pgsql';
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'name',
        'status',
    ];
}
?>