<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Selection_Programs extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'selection_programs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'description',
        'name',
        'active_status',
        'created_by',
        'updated_by',
        'category'
    ];
    public $timestamps = true;

    public static function getSelectionProgram($active_status = '')
    {
        if ($active_status != '') {
            $data = Selection_Programs::select(
                'id',
                'name',
                'description',
                'active_status',
                DB::raw('case when active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
                'category'
            )
                ->where('active_status', '=', $active_status)
                ->orderBy('id', 'desc')
                ->get();
        } else {
            $data = Selection_Programs::select(
                'id',
                'name',
                'description',
                'active_status',
                DB::raw('case when active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
                'category'
            )
                ->orderBy('id', 'desc')
                ->get();
        }
        return $data;
    }
}
