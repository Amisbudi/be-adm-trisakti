<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Document_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'document_type';
    protected $primaryKey = 'id';

    public static function GetDocumentType($name=''){
        if($name != ''){
            $data = Document_Type::select('id','name','description')
                    ->where('name','like','%'.$name.'%')
                    ->get();
        } else {
            $data = Document_Type::select('id','name','description')
                    ->get();
        }
        return $data;
    }

}
?>