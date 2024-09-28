<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Master_Matpel extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'master_matpel';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
    public $timestamps = true;
}
