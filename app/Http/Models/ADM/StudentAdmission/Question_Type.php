<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Question_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'question_type';

}
?>