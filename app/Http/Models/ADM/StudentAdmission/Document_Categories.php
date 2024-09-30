<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Categories extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_categories';
    protected $primaryKey = 'id';
    protected $fillable = [ 
        'name',
        'status',
    ];
    public $timestamps = true;

}
?>