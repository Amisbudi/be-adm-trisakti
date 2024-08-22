<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Participant_Document extends Model {
    protected $connection = 'pgsql';
    protected $table = 'participant_documents';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'document_id',
        'participant_id',
    	'created_by',
    	'updated_by',
    ];
    public $timestamps = true;

    public static function ViewParticipantDocument ($participant_id){
        $data = Participant_Document::select('participant_id','document_id')
            ->where('participant_id','=',$participant_id);
        return $data;
    }
}
?>