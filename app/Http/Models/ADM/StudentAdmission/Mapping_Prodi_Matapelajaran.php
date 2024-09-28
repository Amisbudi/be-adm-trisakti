<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Matapelajaran extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_matapelajaran';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fakultas',
        'fakultas_id',
        'prodi_id',
        'nama_prodi',
        'mata_pelajaran',
        'pelajaran_id',
        'status'
    ];
    public $timestamps = true;
}
