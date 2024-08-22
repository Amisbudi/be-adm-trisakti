<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Supporting extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_supporting';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_id',
        'pic_name',
        'pic_phone_number',
        'pic_email_address',
    	'created_by',
    	'updated_by',
        'pic_address',
        'registration_number'
    ];
    public $timestamps = true;

}
?>