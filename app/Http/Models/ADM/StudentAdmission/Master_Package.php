<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Master_Package extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'master_package_biaya';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_paket',
        'angsuran',
        'study_program_id',
    ];
    public $timestamps = true;
}
