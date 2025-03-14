<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selection_Category extends Model {
    protected $connection = 'pgsql';
    protected $table = 'selection_category';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'active_status'];
    public $timestamps = true;

    public static function GetSelectionCategory(){
        $data = Selection_Category::select('id','name','description')
            ->where('active_status','=','t')
            ->get();
        return $data;
    }

    public static function getCategoryName($id) {
        $data = Selection_Category::select('name')
            ->where('id','=',$id)
            ->first();
        
        return $data;
    }

}
?>