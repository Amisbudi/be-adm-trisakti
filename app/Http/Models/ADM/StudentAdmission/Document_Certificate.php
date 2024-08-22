<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Certificate extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_certificate';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_id',
        'certificate_type_id',
        'certificate_level_id',
        'publication_year',
    	'created_by',
    	'updated_by',
        'certificate_score',
        'registration_number'
    ];
    public $timestamps = true;

}
?>