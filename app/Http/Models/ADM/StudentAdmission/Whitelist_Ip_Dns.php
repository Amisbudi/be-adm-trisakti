<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Whitelist_Ip_Dns extends Model {
    protected $connection = 'framework';
    protected $table = 'whitelist_ip_dns';
    protected $primaryKey = 'id';
    public $timestamps = true;

}
?>