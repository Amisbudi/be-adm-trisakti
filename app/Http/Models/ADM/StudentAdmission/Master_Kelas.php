<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Master_kelas extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'master_kelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'class_type',
    ];
    public $timestamps = true;
}
