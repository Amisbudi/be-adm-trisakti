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
        'bpp_pokok',
        'bpp_sks',
        'bpp_i',
        'bpp_ii',
        'bpp_iii',
        'biaya_ujian',
        'add_foreign',
        'biaya_lainnya'
    ];
    public $timestamps = false;
}
