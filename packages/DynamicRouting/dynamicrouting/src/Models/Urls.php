<?php

namespace Package\DR\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Urls extends Model
{
    protected $table = 'urls';
    protected $primaryKey = 'id';
    protected $connection = 'framework';

    public static function GetPrimaryUrls(){
        $app = Urls::select('urls.id as url_id','urls.name as url_name','urls.masked_name as url_masked_name','urls.methods as url_method','urls.parameters as url_parameter','urls.name as function_name','controllers.namespaces as controller_namespaces','urls.scope_id as scope_name')
            // ->leftJoin('functions','functions.id','=','urls.function_id')
            // ->leftJoin('oauth_scopes','oauth_scopes.id','=','urls.scope_id')
            ->leftJoin('controllers','controllers.id','=','urls.controller_id')
            ->leftJoin('applications', 'applications.id', '=', 'controllers.application_id')
            ->leftJoin('owners', 'owners.id', '=', 'applications.owner_id')
            ->where('owners.id', '=', 1)
            ->orderBy('urls.id', 'asc')
            ->distinct()
            ->get()
            ->toArray();
        return $app;
    }
}
