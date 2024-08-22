<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration_Document extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registration_documents';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'registration_number',
        'mapping_path_document_id',
        'document_url',
    	'created_by',
    	'updated_by',
        'document_payment_ability_id',
        'document_recommendation_letter_id',
    ];
    public $timestamps = true;

}
?>