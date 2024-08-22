<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selection_Category extends Model {
    protected $connection = 'pgsql';
    protected $table = 'selection_category';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public static function GetSelectionCategory(){
        $data = Selection_Category::select('id','name','description')
            ->where('active_status','=','t')
            ->get();
        return $data;
    }

}
?>