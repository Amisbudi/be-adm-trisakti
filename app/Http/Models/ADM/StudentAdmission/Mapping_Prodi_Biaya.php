<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Biaya extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_biaya';
    protected $primaryKey = 'id';
    protected $fillable = [
        'prodi_fk',
        'nama_prodi',
        'kelas_fk',
        'nama_kelas',
        'spp_i',
        'spp_ii',
        'spp_iii',
        'praktikum',
    ];
    public $timestamps = false;
}
