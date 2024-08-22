<?php

namespace App\Http\Models\ADM\StudentAdmission\ExcelModel;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ParticipantReportCard extends Model implements FromCollection, WithHeadings, WithTitle
{
    protected $table = 'registrations as x';
    protected $primaryKey = 'id';
    protected $connection = 'pgsql';

    function __construct($selection_path=null, $mapping_path_year_id=null)
    {
        $this->selection_path = $selection_path;
        $this->mapping_path_year_id = $mapping_path_year_id;
    }

    public function collection()
    {
        $selection_path = $this->selection_path;
        $mapping_path_year_id = $this->mapping_path_year_id;

        $joinA = '
        (
            select
                *
            from
                crosstab($$SELECT a.registration_number,
                \'english_\' || semester_id as sems,
                a.english
            from
                document_report_card as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            order by
                1,
                2 $$,
                $$VALUES (\'english_1\'),
                (\'english_2\'),
                (\'english_3\'),
                (\'english_4\'),
                (\'english_5\'),
                (\'english_6\')$$)
        as ct (registration_number text,
                english_1 text,
                english_2 text,
                english_3 text,
                english_4 text,
                english_5 text,
                english_6 text)
        ) as a
        ';

        $joinB = '
        (
            select
                *
            from
                crosstab($$SELECT a.registration_number,
                \'bahasa_\' || semester_id as sems,
                a.bahasa
            from
                document_report_card as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            order by
                1,
                2 $$,
                $$VALUES (\'bahasa_1\'),
                (\'bahasa_2\'),
                (\'bahasa_3\'),
                (\'bahasa_4\'),
                (\'bahasa_5\'),
                (\'bahasa_6\')$$)
        as ct (registration_number text,
                bahasa_1 text,
                bahasa_2 text,
                bahasa_3 text,
                bahasa_4 text,
                bahasa_5 text,
                bahasa_6 text)
        ) as b
        ';

        $joinC = '
        (
            select
                *
            from
                crosstab($$SELECT a.registration_number,
                \'math_\' || semester_id as sems,
                a.math
            from
                document_report_card as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            order by
                1,
                2 $$,
                $$VALUES (\'math_1\'),
                (\'math_2\'),
                (\'math_3\'),
                (\'math_4\'),
                (\'math_5\'),
                (\'math_6\')$$)
        as ct (registration_number text,
                math_1 text,
                math_2 text,
                math_3 text,
                math_4 text,
                math_5 text,
                math_6 text)
        ) as c
        ';

        $joinD = '
        (
            select
                *
            from
                crosstab($$SELECT a.registration_number,
                \'physics_\' || semester_id as sems,
                a.physics
            from
                document_report_card as a
            join registrations as c on
                (a.registration_number = c.registration_number)
            order by
                1,
                2 $$,
                $$VALUES (\'physics_1\'),
                (\'physics_2\'),
                (\'physics_3\'),
                (\'physics_4\'),
                (\'physics_5\'),
                (\'physics_6\')$$)
        as ct (registration_number text,
                physics_1 text,
                physics_2 text,
                physics_3 text,
                physics_4 text,
                physics_5 text,
                physics_6 text)
        ) as d
        ';

        $joinE = '
        (
            select
                *
            from
                crosstab($$
                select
                    distinct a.registration_number,
                    \'url_\' || semester_id as sems,
                    d.url
                from
                    document_report_card as a
                join registrations as c on
                    (a.registration_number = c.registration_number)
                join documents as d on
                    (a.document_id = d.id)
                order by
                    1,
                    2 $$,
                    $$VALUES (\'url_1\'),
                    (\'url_2\'),
                    (\'url_3\'),
                    (\'url_4\'),
                    (\'url_5\'),
                    (\'url_6\')$$)
        as ct (registration_number text,
                url_1 text,
                url_2 text,
                url_3 text,
                url_4 text,
                url_5 text,
                url_6 text) 
        ) as e
        ';

        $data = ParticipantReportCard::select(
            'x.registration_number',
            'c.math_1',
            'd.physics_1',
            'b.bahasa_1',
            'a.english_1',
            'e.url_1',
            'c.math_2',
            'd.physics_2',
            'b.bahasa_2',
            'a.english_2',
            'e.url_2',
            'c.math_3',
            'd.physics_3',
            'b.bahasa_3',
            'a.english_3',
            'e.url_3',
            'c.math_4',
            'd.physics_4',
            'b.bahasa_4',
            'a.english_4',
            'e.url_4',
            'c.math_5',
            'd.physics_5',
            'b.bahasa_5',
            'a.english_5',
            'e.url_5',
            'c.math_6',
            'd.physics_6',
            'b.bahasa_6',
            'a.english_6',
            'e.url_6'
        )
            ->leftJoin(DB::raw($joinA), function($join) {
                $join->on('a.registration_number', '=', 'x.registration_number');
            })
            ->leftJoin(DB::raw($joinB), function($join) {
                $join->on('b.registration_number', '=', 'x.registration_number');
            })
            ->leftJoin(DB::raw($joinC), function($join) {
                $join->on('c.registration_number', '=', 'x.registration_number');
            })
            ->leftJoin(DB::raw($joinD), function($join) {
                $join->on('d.registration_number', '=', 'x.registration_number');
            })
            ->leftJoin(DB::raw($joinE), function($join) {
                $join->on('e.registration_number', '=', 'x.registration_number');
            })
            ->when($selection_path, function($query) use ($selection_path) {
                return $query->where('x.selection_path_id', $selection_path);
            })
            // ->when($mapping_path_year_id, function($query) use ($mapping_path_year_id) {
            //     return $query->where('x.mapping_path_year_id', $mapping_path_year_id);
            // })
            ->distinct()
            ->get();

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'registration_number',
            'math_1',
            'physics_1',
            'bahasa_1',
            'english_1',
            'url_1',
            'math_2',
            'physics_2',
            'bahasa_2',
            'english_2',
            'url_2',
            'math_3',
            'physics_3',
            'bahasa_3',
            'english_3',
            'url_3',
            'math_4',
            'physics_4',
            'bahasa_4',
            'english_4',
            'url_4',
            'math_5',
            'physics_5',
            'bahasa_5',
            'english_5',
            'url_5',
            'math_6',
            'physics_6',
            'bahasa_6',
            'english_6',
            'url_6',
        ];
    }

    public function title(): string
    {
        return 'Rapor';
    }
}
