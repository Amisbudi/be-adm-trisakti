<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class CBT_Package_Questions extends Model
{
    protected $connection = "pgsql";
    protected $table = "cbt_package_questions";
    protected $primaryKey = "id";
    protected $fillable = ["type_id", "name", "status"];
    public $timestamps = true;
}
