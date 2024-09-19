<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Category extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_category';
    protected $primaryKey = 'id';
    protected $fillable = [
        'prodi_fk',
        'nama_prodi',
        'dokumen_fk',
        'nama_dokumen',
        'selectedstatus'
    ];
    public $timestamps = false;
}
