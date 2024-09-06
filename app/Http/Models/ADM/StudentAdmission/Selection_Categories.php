<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selection_Categories extends Model {
    protected $connection = 'pgsql';
    protected $table = 'selection_categories';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'name',
        'status',
    ];
    public $timestamps = true;

}
?>