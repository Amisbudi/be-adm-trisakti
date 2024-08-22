<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ParticipantCertificate extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations as x';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($selection_path=null,$mapping_path_year_id=null)
    {
        $this->selection_path = $selection_path;
        $this->mapping_path_year_id = $mapping_path_year_id;
    }

    public function collection()
    {
        $selection_path = $this->selection_path;
        $mapping_path_year_id = $this->mapping_path_year_id;

        $subqueryprodi1 = "(
            SELECT 
            a.registration_number, 
            education_fund,
            minimum_donation,
            education_fund + minimum_donation as sdp,
            a.program_study_id,
            priority
        FROM mapping_registration_program_study as a
        join registrations as c on (a.registration_number = c.registration_number)
        JOIN mapping_path_program_study as b on (a.program_study_id = b.program_study_id and c.selection_path_id = b.selection_path_id)
        where priority = 1
        order by registration_number, priority
        ) as y";
       
        $data = ParticipantCertificate::select(
           'x.registration_number',
           'e.url',
           'e.name',
           'e.description',
           'c.type as certificate_type',
           'd.type as certificate_level',
           'b.publication_year',
           'b.certificate_score'
        )
            
            ->leftJoin(DB::raw($subqueryprodi1), function ($join) {
                $join->on('x.registration_number', '=', 'y.registration_number');
            })
            ->leftJoin('document_certificate as b', 'b.registration_number', '=', 'x.registration_number')
            ->leftJoin('certificate_type as c', 'c.id', '=', 'b.certificate_type_id')
            ->leftJoin('certificate_levels as d', 'b.certificate_level_id', '=', 'd.id')
            ->leftjoin('documents as e','b.document_id','=','e.id')
            ->when($selection_path, function($query) use ($selection_path) {
                return $query->where('x.selection_path_id', $selection_path);
            })
            ->whereNotNull('y.program_study_id')
            ->whereNotNull('b.id')
            ->get();

        return collect($data);
    }

    public function headings(): array
    {
        return [
           'registration_number',
           'url',
           'name',
           'description',
           'type as certificate_type',
           'type as certificate_level',
           'publication_year',
           'certificate_score'
        ];
    }

    public function title(): string
    {
        return 'Kejuaraan';
    }
}
