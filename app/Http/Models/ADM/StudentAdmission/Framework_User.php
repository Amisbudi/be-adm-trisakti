<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Framework_User extends Model {
    protected $connection = 'framework';
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [ 
    	'id',
    	'password',
    	'username',
    	'created_by',
    	'updated_by'
    ];
    public $timestamps = true;

}
?>