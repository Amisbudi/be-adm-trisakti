<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Transcript extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_transcript';
    protected $primaryKey = 'id';
    protected $fillable = [
        'document_id',
        'total_credit',
        'total_course',
        'registration_number',
        'created_by',
        'updated_by',
        'printed_at',
        'printed_by',
        'printed_url'
    ];
    public $timestamps = true;

}
?>