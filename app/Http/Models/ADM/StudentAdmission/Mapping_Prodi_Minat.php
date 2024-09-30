<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Minat extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_minat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fakultas',
        'fakultas_id',
        'prodi_id',
        'nama_prodi',
        'nama_minat',
        'minat_id',
        'quota',
        'status'
    ];
    public $timestamps = true;
}
