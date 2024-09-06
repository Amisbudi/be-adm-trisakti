<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Student_Interest extends Model {
    protected $connection = 'pgsql';
    protected $table = 'student_interest';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'interest_type',
        'status',
    ];
    public $timestamps = true;

}
?>