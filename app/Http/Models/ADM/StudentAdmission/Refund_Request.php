<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Refund_Request extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'refund_request';
    protected $primaryKey = 'id';

    protected $fillable = [
        'registration_number',
        'nama',
        'alamat',
        'identitas',
        'no_identitas',
        'no_rek',
        'nama_bank',
        'nama_pemilik',
        'hubungan_pemilik',
        'tanggal_transfer',
        'biaya_paket',
        'biaya_admisistrasi',
        'biaya_pengembalian',
        'document_url',
        'approval_keuangan',
        'approval_keuangan_by',
        'approval_keuangan_date',
        'approval_fakultas',
        'approval_fakultas_by',
        'approval_fakultas_date',
        'approval_universitas',
        'approval_universitas_by',
        'approval_universitas_date',
    ];

    public $timestamps = true;
}
