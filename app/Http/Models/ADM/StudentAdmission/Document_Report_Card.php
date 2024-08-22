<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Report_Card extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_report_card';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'semester_id',
        'document_id',
        'range_score',
    	'created_by',
    	'updated_by',
        'math',
        'physics',
        'bahasa',
        'english',
        'biology',
        'economy',
        'geography',
        'sociological',
        'historical',
        'chemical',
        'registration_number',
        'gpa'
    ];
    public $timestamps = true;

}
?>