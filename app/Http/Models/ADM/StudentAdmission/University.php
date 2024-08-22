<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class University extends Model {
    protected $connection = 'masterdata';
    protected $table = 'universities';
    public $timestamps = true;
    protected $primaryKey = 'npsn';
    public $incrementing = false;
    protected $keyType = 'string';
}
?>