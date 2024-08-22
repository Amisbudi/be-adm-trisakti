<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Sheet4 extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'mapping_registration_program_study';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($selection_path=null)
    {
        $this->selection_path = $selection_path;
    }

    public function collection()
    {
        $selection_path = $this->selection_path;

        $subqueryprodiandfaculty = "(
            select
                faculty_id,
                id,
                study_program_name,
                study_program_name_en,
                faculty_name
            from
                dblink( 'admission_academic',
                'select sp.faculty_id, sp.id, sp.study_program_name, sp.study_program_name_en, f.faculty_name, sp.active_status, f.university_id, f.active_status as active_faculty from academic.public.study_programs as sp join academic.public.faculties as f on (sp.faculty_id = f.id)') as t1 ( faculty_id int,
                id int ,
                study_program_name varchar,
                study_program_name_en varchar,
                faculty_name varchar,
                active_status int,
                university_id int,
                active_faculty int)
            where
                active_status = 1
                and university_id = 30
                and active_faculty = 1
        ) as t1";

        $subquerylasteducation = "(
            select
                DISTINCT ON (participant_educations.participant_id) participant_id,
                case
                    when participant_educations.school_id is null then participant_educations.school
                    else s.name
                end as school_name,
                participant_educations.graduate_year,
                s.npsn
            from
                participant_educations
            left join schools as s on
                participant_educations.school_id = s.id
            inner join education_degrees as ed on
                participant_educations.education_degree_id = ed.id
            order by
                participant_educations.participant_id asc,
                participant_educations.graduate_year desc) as t2";

        $data = Sheet4::select(
            'r.registration_number',
            'sp.name as selection_path',
            'p.fullname',
            'mapping_registration_program_study.priority',
            't1.study_program_name',
            't1.faculty_name',
            'mapping_registration_program_study.education_fund',
            DB::raw("CASE WHEN p.color_blind = 't' THEN 'Iya' ELSE 'Tidak' END AS color_blind"),
            DB::raw("CASE WHEN p.special_needs IS NULL THEN '-' ELSE p.special_needs END AS special_needs"),
            't2.school_name',
            't2.npsn'
        )
            ->leftJoin('registrations as r', 'mapping_registration_program_study.registration_number', '=', 'r.registration_number')
            ->join('selection_paths as sp', 'r.selection_path_id', '=', 'sp.id')
            ->leftJoin('participants as p', 'r.participant_id', '=', 'p.id')
            ->leftJoin(DB::raw($subqueryprodiandfaculty), function ($join) {
                $join->on('mapping_registration_program_study.program_study_id', '=', 't1.id');
            })
            ->leftJoin(DB::raw($subquerylasteducation), function ($join) {
                $join->on('p.id', '=', 't2.participant_id');
            })
            ->when($selection_path, function($query) use ($selection_path) {
                return $query->where('sp.id', $selection_path);
            })
            ->orderBy('mapping_registration_program_study.registration_number')
            ->orderBy('mapping_registration_program_study.priority')
            ->get();

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Nomor Registrasi',
            'Jalur Seleksi',
            'Nama',
            'Prioritas',
            'Program Studi',
            'Fakultas',
            'SDP2',
            'Buta Warna',
            'Kebutuhan Khusus',
            'Sekolah / Universitas',
            'NPSN'
        ];
    }

    public function title(): string
    {
        return 'sheet1';
    }
}
