<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Publication_Writer_Position extends Model {
    protected $connection = 'pgsql';
    protected $table = 'publication_writer_position';
    public $timestamps = true;
}
?>