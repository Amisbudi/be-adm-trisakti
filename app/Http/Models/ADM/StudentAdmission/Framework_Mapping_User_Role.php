<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Framework_Mapping_User_Role extends Model {
    protected $connection = 'framework';
    protected $table = 'mapping_user_role';
    protected $primaryKey = 'id';
    protected $fillable = [ 
    	'user_id',
    	'oauth_role_id',
    	'created_by',
    	'updated_by'
    ];
    public $timestamps = true;

    public static function getMappingUserRoleById($user_id)
    {
        $data = Framework_Mapping_User_Role::select(
            'mapping_user_role.id',
            'mapping_user_role.user_id',
            'mapping_user_role.oauth_role_id',
            'or.name as oauth_role'
        )
            ->join('oauth_roles as or', 'mapping_user_role.oauth_role_id', '=', 'or.id')
            ->where('mapping_user_role.user_id', '=', $user_id)
            ->first();

        return $data;
    } 
}
?>