<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ParticipantRegistrationData extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations as a';
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

        $subquerylasteducation = "(
            select
                a.participant_id,
                case
                    when d.major is null then a.education_major
                    else d.major
                end as education_major,
                case
                    when c.name is null then a.school
                    else c.name
                end as schools,
                case
                    when c.name is null then ''
                    else c.npsn
                end as npsn,
                a.graduate_year
            from
                participant_educations as a
            left join education_degrees as b on
                (a.education_degree_id = b.id)
            left join schools as c on
                (a.school_id = c.id)
            left join education_majors as d on
                (a.education_major_id = d.id)
            join (
                select
                    max(graduate_year) as graduate_year,
                    participant_id
                from
                    participant_educations
                group by
                    participant_id 
                ) as e on
                (a.participant_id = e.participant_id
                    and e.graduate_year = a.graduate_year)) as d";

        $prodi = '
        (
            select
                *
            from
                crosstab($$SELECT a.registration_number,
                \'prodi_\' || priority as val,
                a.program_study_id
            from
                mapping_registration_program_study as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            join mapping_path_program_study as b on
                (a.program_study_id = b.program_study_id
                    and c.selection_path_id = b.selection_path_id)
        union
            select
                a.registration_number,
                \'sdp_\' || priority as val,
                education_fund + minimum_donation as sdp
            from
                mapping_registration_program_study as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            join mapping_path_program_study as b on
                (a.program_study_id = b.program_study_id
                    and c.selection_path_id = b.selection_path_id)
            order by
                1,
                2 $$,
                $$VALUES (\'prodi_1\'),
                (\'prodi_2\'),
                (\'prodi_3\'),
                (\'prodi_4\'),
                (\'prodi_5\'),
                (\'sdp_1\'),
                (\'sdp_2\'),
                (\'sdp_3\'),
                (\'sdp_4\'),
                (\'sdp_5\')$$)
        as ct (registration_number text,
                prodi_1 int,
                prodi_2 int,
                prodi_3 int,
                prodi_4 int,
                prodi_5 int,
                sdp_1 int,
                sdp_2 int,
                sdp_3 int,
                sdp_4 int,
                sdp_5 int)
          ) as x
        ';
        $data = ParticipantRegistrationData::select(
            "a.registration_number",
            "a.selection_path_id",
            "b.fullname",
            "b.special_needs",
            "b.color_blind",
            "d.education_major",
            "d.schools",
            "d.npsn",
            "d.graduate_year",
            'x.prodi_1',
            'x.sdp_1 as sdp_prodi_1',
            'x.prodi_2',
            'x.sdp_2 as sdp_prodi_2',
            'x.prodi_3',
            'x.sdp_3 as sdp_prodi_3',
            'x.prodi_4',
            'x.sdp_4 as sdp_prodi_4',
            'x.prodi_5',
            'x.sdp_5 as sdp_prodi_5'
        )
            ->leftJoin('participants as b', 'a.participant_id', '=', 'b.id')
            ->leftJoin(DB::raw($subquerylasteducation), function ($join) {
                $join->on('b.id', '=', 'd.participant_id');
            })
            ->leftJoin(DB::raw($prodi), function ($join) {
                $join->on('a.registration_number', '=', 'x.registration_number');
            })
            ->when($selection_path, function($query) use ($selection_path) {
                return $query->where('a.selection_path_id', $selection_path);
            })
            // ->when($mapping_path_year_id, function($query) use ($mapping_path_year_id) {
            //     return $query->where('a.mapping_path_year_id', $mapping_path_year_id);
            // })
            ->get();
            
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'registration_number',
            'selection_path_id',
            'fullname',
            'special_needs',
            'color_blind',
            'education_major',
            'schools',
            'npsn',
            'graduate_year',
            'prodi_1',
            'sdp_prodi_1',
            'prodi_2',
            'sdp_prodi_2',
            'prodi_3',
            'sdp_prodi_3',
            'prodi_4',
            'sdp_prodi_4',
            'prodi_5',
            'sdp_prodi_5'
        ];
    }

    public function title(): string
    {
        return 'Registrasi';
    }
}
