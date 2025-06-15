<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Diskon_Khusus extends Model {
    protected $connection = 'pgsql';
    protected $table = 'diskon_khusus';

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'registration_number',
        'type',
        'kode_voucher',
        'document_url',
        'approved_by',
        'approved_at'
    ];
}
?>