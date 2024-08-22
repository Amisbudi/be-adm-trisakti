<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Transcript_Participant extends Model {
    protected $connection = 'pgsql';
    protected $table = 'mapping_transcript_participant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'course_code',
        'course_name',
        'credit_hour',
        'grade',
        'document_transcript_id',
        'created_by',
        'updated_by',
        'course_code_approved',
        'course_name_approved',
        'credit_hour_approved',
        'grade_approved',
        'approval_at',
        'approval_by'
    ];
    public $timestamps = true;

}
?>