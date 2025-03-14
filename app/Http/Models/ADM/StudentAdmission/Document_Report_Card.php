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
        'mapel11',
        'mapel12',
        'alias1',
        'alias2',
        'alias3',
        'alias4',
        'alias5',
        'alias6',
        'alias7',
        'alias8',
        'alias9',
        'alias10',
        'alias11',
        'alias12',
        'registration_number',
        'gpa'
    ];
    public $timestamps = true;

}
?>