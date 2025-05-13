<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class CBT_Package_Question_Users extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'cbt_package_question_users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'package_question_id',
        'registration_number',
        'user_id',
        'classes',
        'date_exam',
        'date_start',
        'date_end',
        'status',
    ];
    public $timestamps = true;
}
