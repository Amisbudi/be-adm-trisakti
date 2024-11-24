<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Prodi_Formulir extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_prodi_formulir';
    protected $primaryKey = 'id';
    protected $fillable = [
        'prodi_fk',
        'nama_prodi',
        'nama_formulir',
        'harga',
        'add_cost',
        'exam_status',
        'kategori_formulir'
    ];
    public $timestamps = false;
}
