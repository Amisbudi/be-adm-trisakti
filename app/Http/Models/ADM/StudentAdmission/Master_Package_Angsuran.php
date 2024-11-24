<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Master_Package_Angsuran extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'master_detail_package_biaya';
    protected $primaryKey = 'id';
    protected $fillable = [
        'package_id',
        'angsuran_ke',
        'spp',
        'bpp',
        'bpp_sks',
        'praktikum',
        'ujian',
        'lainnya',
        'disc',
        'disc_spp',
        'disc_bpp',
        'disc_bpp_sks',
        'disc_praktikum',
        'disc_lainnya',
    ];
    public $timestamps = true;
}
