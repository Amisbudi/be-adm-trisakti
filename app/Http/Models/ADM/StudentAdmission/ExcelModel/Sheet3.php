<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class Sheet3 extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registration_result';
	protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($program=null, $selection_path=null, $registration_number=null)
    {
        $this->program = $program;
		$this->selection_path = $selection_path;
        $this->registration_number = $registration_number;
    }

    public function collection()
    {
        $program = $this->program;
        $selection_path = $this->selection_path;
        $registration_number = $this->registration_number;
        
        $pass_status =  DB::raw('case when registration_result.pass_status = '."'f'".' then '."'Tidak Lulus'".' when registration_result.pass_status = '."'t'".' then '."'Lulus'".' else '."'Belum Ditentukan'".' end as pass_status_name');

        $subquery = '(select
                    id,
                    study_program_name,
                    study_program_name_en,
                    faculty_name
                FROM
                dblink( '."'admission_academic'".','."'select sp.id, sp.study_program_name, sp.study_program_name_en, f.faculty_name, sp.active_status, f.university_id, f.active_status as active_faculty from academic.public.study_programs as sp join academic.public.faculties as f on (sp.faculty_id = f.id)'".') AS t1 ( id int , study_program_name varchar, study_program_name_en varchar, faculty_name varchar,active_status int, university_id int, active_faculty int) where active_status = 1 and university_id = 30 and active_faculty = 1) as t1';

        $data = Sheet3::select('p.name as program_name','sp.name as selection_path_name','registrations.registration_number','pr.fullname','pr.username','pr.mobile_phone_number','registration_result.total_score',$pass_status,'t1.faculty_name','t1.study_program_name')
        ->join('registrations','registration_result.registration_number','=','registrations.registration_number')
        ->join('participants as pr','registrations.participant_id','=','pr.id')
        ->join('selection_paths as sp','registrations.selection_path_id','=','sp.id')
        ->join('selection_programs as p','p.id','=','sp.selection_program_id')
        ->join('mapping_registration_program_study as mr','registration_result.mapping_registration_program_study_id','=','mr.id')
        ->join('mapping_path_program_study as mps','mr.mapping_path_study_program_id','=','mps.id')
        ->leftjoin(DB::raw($subquery), 
                function($join)
                {
                   $join->on('mps.program_study_id', '=', 't1.id');
                })
        ->when($program, function($query) use ($program){return $query->where('sp.selection_program_id', $program);})
        ->when($selection_path, function($query) use ($selection_path){return $query->where('sp.id', $selection_path);})
        ->when($registration_number, function($query) use ($registration_number){return $query->where('registrations.registration_number', $registration_number);})
        ->get()
        ->toArray();
        // return $data;
		return collect($data);
    }

    public function headings(): array
    {	
    	return [
		            'Program Name',
		            'Selection Path',
		            'Registration Number',
		            'Full Name',
		            'Email',
                    'Phone Number',
                    'Total Score',
                    'Result',
                    'Faculty',
                    'Study Program'		            
		        ];
    }

    public function title(): string
    {
        return 'Registration Result List';
    }
}
