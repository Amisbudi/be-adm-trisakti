<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Announcement_Registration_Card extends Model {
    protected $connection = 'pgsql';
    protected $table = 'announcement_registration_card';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'tittle',
        'start_date',
        'notes',
        'selection_program_category',
        'active_status',
        'ordering',
        'exam_type',
    	'created_by',
    	'updated_by'
    ];

    public $timestamps = true;
}
?>