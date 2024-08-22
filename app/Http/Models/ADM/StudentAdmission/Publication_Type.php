<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Publication_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'publication_type';
    public $timestamps = true;
}
?>