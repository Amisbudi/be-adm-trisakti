<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class Sheet1 extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations';
	protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($start_date=null, $end_date=null, $program=null, $selection_path=null, $nationality=null)
    {
        $this->program = $program;
		$this->selection_path = $selection_path;
		$this->nationality = $nationality;
		$this->start_date = $start_date;
		$this->end_date = $end_date;
    }

    public function collection()
    {
        $program = $this->program;
        $selection_path = $this->selection_path;
		$nationality = $this->nationality;
		$start_date = $this->start_date;
		$end_date = $this->end_date;

        $filter = DB::raw('1');

        if ($start_date != null) {
            $start_date_filter = ['registrations.created_at', '>=', date($start_date)];
        } else {
            $start_date_filter = [$filter, '=', '1'];
        }

        if ($end_date != null) {
            $end_date_filter = ['registrations.created_at', '<=', date($end_date)];
        } else {
            $end_date_filter = [$filter, '=', '1'];
        }
        
        $regist_history = DB::raw('(select max(registration_step_id) as registration_step_id, registration_number from registration_history group by registration_number) as rh');

        $pass_status = DB::raw('case when rr.pass_status = '."'f'".' then '."'Tidak Lulus'".' when rr.pass_status = '."'t'".' then '."'Lulus'".' else '."'Belum Ditentukan'".' end as pass_status_name');
        $data = Sheet1::select('registrations.registration_number','p.fullname','p.username as email','p.mobile_phone_number','sp.name as selection_path_name','ps.status as payment_status',$pass_status)
        ->leftjoin(DB::raw($regist_history), 
                function($join)
                {
                   $join->on('rh.registration_number', '=', 'registrations.registration_number');
                })
        ->leftjoin('registration_steps as rs','rh.registration_step_id','=','rs.id')
        ->leftjoin('payment_status as ps','registrations.payment_status_id','=','ps.id')
        ->leftjoin('participants as p','registrations.participant_id','=','p.id')
        ->leftjoin('selection_paths as sp','registrations.selection_path_id','=','sp.id')
        ->leftjoin('registration_result as rr','registrations.registration_number','=','rr.registration_number')
        ->when($program, function($query) use ($program){return $query->where('sp.selection_program_id', $program);})
        ->when($selection_path, function($query) use ($selection_path){return $query->where('sp.id', $selection_path);})
        ->when($nationality, function($query) use ($nationality){return $query->where('p.nationality', $nationality);})
        ->where([$start_date_filter, $end_date_filter])
        ->orderBy('registrations.registration_number')
        ->distinct()
        ->get()
        ->toArray();
        // return $data;
		return collect($data);
    }

    public function headings(): array
    {	
    	return [
                    'Registration Number',
		            'Full Name',
		            'Email',
		            'Phone Number',
		            'Selection Path',
		            'Payment Status',
                    'Pass Status'		            
		        ];
    }

    public function title(): string
    {
        return 'Participant Registration List';
    }
}
