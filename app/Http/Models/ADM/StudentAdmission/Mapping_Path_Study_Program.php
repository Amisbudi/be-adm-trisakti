<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Mapping_Path_Study_Program extends Model
{
    protected $connection = 'pgsql';
    protected $table = 'mapping_path_program_study as msp';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_study_id',
        'selection_path_id',
        'created_by',
        'updated_by',
        'active_status',
        'quota',
        'minimum_donation',
        'is_technic'
    ];
    public $timestamps = true;

    public static function ViewMappingPathStudyProgram($selection_path_id, $isActive, $id, $is_technic)
    {
        //filter active status
        $filter = DB::raw('1');

        if ($isActive) {
            $active_status = ['msp.active_status', '=', $isActive];
        } else {
            $active_status = [$filter, '=', 1];
        }

        if ($id != null) {
            $filter_id = ['msp.id', '=', $id];
        } else {
            $filter_id = [$filter, '=', 1];
        }

        if ($is_technic != null) {
            $is_technic_filter = ['msp.is_technic', '=', $is_technic];
        } else {
            $is_technic_filter = [$filter, '=', 1];
        }
        
        $data = Mapping_Path_Study_Program::select(
            'msp.selection_path_id',
            't1.study_program_branding_name as study_program_name',
            't1.classification_id as study_program_id',
            't1.faculty_id',
            't1.faculty_name',
            'msp.quota',
            'msp.active_status',
            'msp.minimum_donation',
            'msp.id',
            DB::raw('case when msp.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            DB::raw("CASE WHEN msp.is_technic = 't' THEN msp.is_technic ELSE 'false' END AS is_technic"),
            // Add a new column to calculate the sum of prices
            DB::raw('SUM(mpp.price) AS total_price') // Replace 'mpp.price' with the actual price column name
        )
        ->join('study_programs as t1', 'msp.program_study_id', '=', 't1.classification_id')
        ->leftJoin('mapping_path_price AS mpp', function ($join) use ($selection_path_id) {
            $join->on('msp.program_study_id', '=', 'mpp.study_program_id');
            // Optional: Add filtering conditions on 'mpp' table if needed
            // $join->where('mpp.some_condition', '=', $some_value);
        })
        ->where('msp.selection_path_id', '=', $selection_path_id)
        ->where([$active_status, $filter_id, $is_technic_filter])
        ->groupBy('msp.selection_path_id', 't1.study_program_branding_name', 't1.classification_id', 't1.faculty_id', 't1.faculty_name', 'msp.quota', 'msp.active_status', 'msp.minimum_donation', 'msp.id', 'active_status_name', 'is_technic') // Group by relevant columns
        ->get();
        
        return $data;
    }
}
