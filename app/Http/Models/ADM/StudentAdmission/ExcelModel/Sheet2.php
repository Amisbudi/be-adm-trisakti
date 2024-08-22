<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class Sheet2 extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations';
	protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($program=null, $selection_path=null, $payment_status=null, $payment_method=null)
    {
        $this->program = $program;
		$this->selection_path = $selection_path;
        $this->payment_status = $payment_status;
        $this->payment_method = $payment_method;
    }

    public function collection()
    {
        $program = $this->program;
        $selection_path = $this->selection_path;
		$payment_status = $this->payment_status;
        $payment_method = $this->payment_method;
        
        $data = Sheet2::select(
            'registrations.registration_number',
            'sp.name as selection_path_name',
            'mpp.price',
            'pm.method as payment_method_name',
            'ps.status as payment_status_name'
        )
        ->leftjoin('payment_methods as pm','pm.id','=','registrations.payment_method_id')
        ->leftjoin('payment_status as ps','registrations.payment_status_id','=','ps.id')
        ->leftjoin('mapping_path_price as mpp','mpp.id','=','registrations.mapping_path_price_id')
        ->leftjoin('selection_paths as sp','registrations.selection_path_id','=','sp.id')
        // ->leftjoin('selection_programs as pr','sp.selection_program_id','=','pr.id')
        // ->when($program, function($query) use ($program){return $query->where('sp.selection_program_id', $program);})
        ->when($selection_path, function($query) use ($selection_path){return $query->where('sp.id', $selection_path);})
        ->when($payment_status, function($query) use ($payment_status){return $query->where('registrations.payment_status_id', $payment_status);})
        ->when($payment_method, function($query) use ($payment_method){return $query->where('registrations.payment_method_id', $payment_method);})
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
		            'Selection Path',
		            'Bill',
		            'Payment Method',
		            'Payment Status'		            
		        ];
    }

    public function title(): string
    {
        return 'Registration Payment List';
    }
}
