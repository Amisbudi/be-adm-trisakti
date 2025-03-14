<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Transfer_Credit extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'transfer_credit';
    protected $primaryKey = 'id';
    protected $fillable = [
        'participant_id',
        'kode_matakuliah_ex',
        'nama_matakuliah_ex',
        'sks_ex',
        'nilai_ex',
        'kode_matakuliah',
        'nama_matakuliah',
        'sks',
        'nilai'
    ];
    public $timestamps = false;
}
