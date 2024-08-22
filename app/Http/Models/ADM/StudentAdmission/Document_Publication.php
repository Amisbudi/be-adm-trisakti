<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Publication extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_publication';
    protected $primaryKey = 'id';

    protected $fillable = [ 
        'document_id',
        'writer_name',
        'publication_writer_position_id',
    	'title',
    	'publication_type_id',
        'publish_date',
        'publication_link',
        'created_by',
        'updated_by',
        'participant_id'
    ];

    public $timestamps = true;

}
?>