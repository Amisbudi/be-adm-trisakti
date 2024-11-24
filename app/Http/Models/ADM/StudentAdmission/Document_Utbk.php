<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Utbk extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_utbk';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_id',
    	'created_by',
    	'updated_by',
        'mapel1',
        'mapel2',
        'mapel3',
        'mapel4',
        'mapel5',
        'mapel6',
        'mapel7',
        'mapel8',
        'mapel9',
        'mapel10',
        'registration_number',
        'general_reasoning',
        'quantitative_knowledge',
        'comprehension_general_knowledge',
        'comprehension_reading_knowledge',
        'major_type'
    ];
    public $timestamps = true;

}
?>