<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class PostgraduateRegistration extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($selection_path = null, $mapping_path_year_id = null)
    {
        $this->selection_path = $selection_path;
        $this->mapping_path_year_id = $mapping_path_year_id;
    }

    public function collection()
    {
        $selection_path = $this->selection_path;
        $mapping_path_year_id = $this->mapping_path_year_id;

        $tpa = "(select ds.score, ds.registration_number from document_study as ds left join documents as d on ds.document_id = d.id left join document_type as dt on d.document_type_id = dt.id where lower(dt.name) = 'tpa' limit 1) as tpa";
        $toefl = "(select ds.score, ds.registration_number from document_study as ds left join documents as d on ds.document_id = d.id left join document_type as dt on d.document_type_id = dt.id where lower(dt.name) = 'eprt/toefl' limit 1) as toefl";
        $ipk = "(select ds.score, ds.registration_number from document_study as ds left join documents as d on ds.document_id = d.id left join document_type as dt on d.document_type_id = dt.id where lower(dt.name) = 'ipk' limit 1) as ipk";

        $data = PostgraduateRegistration::select(
            'p.id',
            'registrations.registration_number',
            'p.fullname',
            'p.username as email',
            'p.mobile_phone_number',
            'ipk.score as ipk',
            'tpa.score as tpa',
            'toefl.score as toefl',
            DB::raw("concat('https://situ-adm.telkomuniversity.ac.id/admission/DOC876/?registration_number=', registrations.registration_number, '&id=', p.id) as detail")
        )
            ->leftjoin('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('selection_programs as sps', 'sp.selection_program_id', '=', 'sps.id')
            ->leftjoin(DB::raw($tpa), function ($join) {
                $join->on('registrations.registration_number', '=', 'tpa.registration_number');
            })
            ->leftjoin(DB::raw($toefl), function ($join) {
                $join->on('registrations.registration_number', '=', 'toefl.registration_number');
            })
            ->leftjoin(DB::raw($ipk), function ($join) {
                $join->on('registrations.registration_number', '=', 'ipk.registration_number');
            })
            ->where('sps.category', '=', 'PASCASARJANA')
            ->when($selection_path, function($query) use ($selection_path) {
                return $query->where('registrations.selection_path_id', $selection_path);
            })
            ->when($mapping_path_year_id, function($query) use ($mapping_path_year_id) {
                return $query->where('registrations.mapping_path_year_id', $mapping_path_year_id);
            })
            ->get();

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Id Peserta',
            'Nomor Registrasi',
            'Nama Peserta',
            'Email',
            'Nomor Ponsel',
            'IPK',
            'TPA',
            'TOEFL',
            'Detail'
        ];
    }

    public function title(): string
    {
        return 'Pascasarjana S2 dan S3';
    }
}
