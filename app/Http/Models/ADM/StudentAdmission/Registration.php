<?php

namespace app\Http\Models\ADM\StudentAdmission;

use Illuminate\Database\Eloquent\Model;
use DB;

class Registration extends Model {
    protected $connection = 'pgsql';
    protected $table = 'registrations';
    protected $primaryKey = 'registration_number';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [ 
        'registration_number',      
        'participant_id',
        'selection_path_id',
    	'created_by',
    	'updated_by',
        'payment_method_id',
        'payment_status_id',
        'payment_date',
        'payment_approval_date',
        'payment_approval_by',
        'exam_status',
        'path_exam_detail_id',
        'payment_url',
        'mapping_path_price_id',
        'activation_pin',
        'mapping_location_selection_id',
        'mapping_path_year_id',
        'url',
        'mapping_path_year_intake_id'
    ];
    public $timestamps = true;

    public static function GetRegistrationParticipant($registration_number, $study_program_id) {
        $data['data'] = Registration::select(
            'registrations.registration_number',
            'p.id as participant_id',
            'p.identify_number',
            'p.fullname',
            'p.username as email',
            'p.mobile_phone_number',
            'sp.name as selection_path_name',
            'sp.id as selection_path_id',
            'es.id as exam_status_id',
            DB::raw("case when es.id = 1 then 'Raport' when es.id = 2 then 'CBT' else es.name end as exam_status"),
            'le.location',
            'le.address',
            DB::raw('TO_CHAR(pe.exam_start_date,'."'YYYY-MM-DD'".') as exam_date'),
            DB::raw('CONCAT(TO_CHAR(exam_start_date, '."'HH12:MI:SS'".'),'."' s/d '".',TO_CHAR(exam_end_date, '."'HH12:MI:SS'".')) as exam_hour'),
            'registrations.activation_pin',
            'p.photo_url',
            'p.color_blind',
            'p.special_needs',
            'participant_educations.education_major_id',
            'em.major as education_major',
            'registrations.path_exam_detail_id'
            )
                ->leftjoin('participants as p','registrations.participant_id','=','p.id')
                ->leftJoin('participant_educations', 'participant_educations.participant_id', '=', 'p.id')
                ->leftjoin('selection_paths as sp','registrations.selection_path_id','=','sp.id')
                ->leftjoin('path_exam_details as pe','registrations.path_exam_detail_id','=','pe.id')
                ->leftjoin('mapping_location_selection as mls', 'registrations.mapping_location_selection_id', '=', 'mls.id')
                ->leftjoin('location_exam as le', 'mls.location_exam_id', '=', 'le.id')
                ->leftjoin('exam_type as es','sp.exam_status','=','es.id')
                ->leftjoin('education_majors as em', 'participant_educations.education_major_id', '=', 'em.id')
                ->where('registrations.registration_number','=',$registration_number)
                ->first();

        return $data;
    }

    public static function GetSumParticipant($selection_path_id=null, $study_program_id=null){

        $subquery = '(select
                    id,
                    study_program_name,
                    study_program_name_en,
                    faculty_name
                FROM
                dblink( '."'admission_academic'".','."'select sp.id, sp.study_program_name, sp.study_program_name_en, f.faculty_name, sp.active_status, f.university_id, f.active_status as active_faculty from academic.public.study_programs as sp join academic.public.faculties as f on (sp.faculty_id = f.id)'".') AS t1 ( id int , study_program_name varchar, study_program_name_en varchar, faculty_name varchar,active_status int, university_id int, active_faculty int) where active_status = 1 and university_id = 30 and active_faculty = 1) as t1';

        $data = Registration::select('registrations.registration_number')
        ->join('selection_paths as sp','registrations.selection_path_id','=','sp.id')
        ->join('mapping_registration_program_study as mr','registrations.registration_number','=','mr.registration_number')
        ->join('mapping_path_program_study as mps','mr.mapping_path_study_program_id','=','mps.id')
        ->leftjoin('study_programs as t1', 'mps.program_study_id', '=', 't1.classification_id')
        ->when($selection_path_id, function($query) use ($selection_path_id){return $query->where('sp.id', $selection_path_id);})
        ->when($study_program_id, function($query) use ($study_program_id){return $query->where('t1.classification_id', $study_program_id);})
        ->count();

        return $data;
    }

    public static function GetSumParticipantGender($gen){

        $gender = '(select id, gender from
                dblink( '."'admission_masterdata'".','."'select id,gender from masterdata.public.gender') AS t1 ( id integer, gender varchar )) as gender";

        $data = Registration::select(DB::raw('count(registrations.registration_number)'),'a.gender','gender.gender')
        ->join('participants as a','registrations.participant_id','=','a.id')
        ->join('selection_paths as sp','registrations.selection_path_id','=','sp.id')
        ->leftjoin(DB::raw($gender), 
                function($join)
                {
                   $join->on('a.gender', '=', 'gender.id');
                }) 
         ->when($gen, function($query) use ($gen){return $query->where('a.gender',$gen);})
        ->groupBy('a.gender','gender.gender')
        ->count();

        return $data;
    }

    public static function GetSumParticipantProvince (){

         $address_province = '(select id, address_province from
                dblink( '."'admission_masterdata'".','."'select id, detail_name as address_province from masterdata.public.provinces') AS t1 ( id integer, address_province varchar )) as ap";

        $data = Registration::select(DB::raw('count(registrations.registration_number)'),'a.address_province','ap.address_province')
        ->join('participants as a','registrations.participant_id','=','a.id')
        ->leftjoin(DB::raw($address_province), 
                function($join)
                {
                   $join->on('ap.id', '=', 'a.address_province');
                }) 
        ->groupBy('a.address_province','ap.address_province')
        ->get();

        return $data;
    }

    public static function GetSumParticipantCity (){

         $address_city = '(select id, address_city from
                dblink( '."'admission_masterdata'".','."'select id, detail_name as address_city from masterdata.public.city_regions') AS t1 ( id integer, address_city varchar )) as aci";

        $data = Registration::select(DB::raw('count(registrations.registration_number)'),'a.address_city','aci.address_city')
        ->join('participants as a','registrations.participant_id','=','a.id')
        ->leftjoin(DB::raw($address_city), 
                function($join)
                {
                   $join->on('aci.id', '=', 'a.address_city');
                }) 
        ->groupBy('a.address_city','aci.address_city')
        ->get();

        return $data;
    }

    public static function GetSumParticipantSchool(){
        $data = Registration::select(DB::raw('count(registrations.registration_number)'),'pe.school_id','s.name')
            ->join('participant_educations as pe','registrations.participant_id','=','pe.participant_id')
            ->join('schools as s','pe.school_id','=','s.id')
            ->whereIn('pe.education_degree_id', [1, 2, 3])
            ->groupBy('school_id','s.name')
            ->get();

        return $data;
    }

}
