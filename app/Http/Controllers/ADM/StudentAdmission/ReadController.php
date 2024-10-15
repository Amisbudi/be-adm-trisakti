<?php

namespace app\Http\Controllers\ADM\StudentAdmission;

use App\Http\Controllers\Controller;
use App\Http\Models\ADM\StudentAdmission\Announcement_Registration_Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use DB;
use PDF;
use Storage;
use Excel;

use App\Http\Models\ADM\StudentAdmission\Participant;
use App\Http\Models\ADM\StudentAdmission\Selection_Programs;
use App\Http\Models\ADM\StudentAdmission\Location_Exam;
use App\Http\Models\ADM\StudentAdmission\City_Region;
use App\Http\Models\ADM\StudentAdmission\Document_Type;
use App\Http\Models\ADM\StudentAdmission\Registration_Steps;
use App\Http\Models\ADM\StudentAdmission\Selection_Path;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Step;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Document;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Price;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Study_Program;
use App\Http\Models\ADM\StudentAdmission\Question_Type;
use App\Http\Models\ADM\StudentAdmission\Questionare;
use App\Http\Models\ADM\StudentAdmission\Question;
use App\Http\Models\ADM\StudentAdmission\Answer_Option;
use App\Http\Models\ADM\StudentAdmission\Religion;
use App\Http\Models\ADM\StudentAdmission\Nationality;
use App\Http\Models\ADM\StudentAdmission\Marriage_Status;
use App\Http\Models\ADM\StudentAdmission\Gender;
use App\Http\Models\ADM\StudentAdmission\School;
use App\Http\Models\ADM\StudentAdmission\Education_Major;
use App\Http\Models\ADM\StudentAdmission\Education_Degree;
use App\Http\Models\ADM\StudentAdmission\Participant_Education;
use App\Http\Models\ADM\StudentAdmission\Participant_Family;
use App\Http\Models\ADM\StudentAdmission\Family_Relationship;
use App\Http\Models\ADM\StudentAdmission\Work_Field;
use App\Http\Models\ADM\StudentAdmission\Participant_Work_Data;
use App\Http\Models\ADM\StudentAdmission\Registration;
use App\Http\Models\ADM\StudentAdmission\Payment_Method;
use App\Http\Models\ADM\StudentAdmission\Mapping_Registration_Program_Study;
use App\Http\Models\ADM\StudentAdmission\Study_Program;
use App\Http\Models\ADM\StudentAdmission\Document;
use App\Http\Models\ADM\StudentAdmission\Participant_Document;
use App\Http\Models\ADM\StudentAdmission\Document_Publication;
use App\Http\Models\ADM\StudentAdmission\Document_Report_Card;
use App\Http\Models\ADM\StudentAdmission\Semester;
use App\Http\Models\ADM\StudentAdmission\Range_Score;
use App\Http\Models\ADM\StudentAdmission\Certificate_Level;
use App\Http\Models\ADM\StudentAdmission\Document_Certificate;
use App\Http\Models\ADM\StudentAdmission\Mapping_Location_Selection;
use App\Http\Models\ADM\StudentAdmission\Path_Exam_Detail;
use App\Http\Models\ADM\StudentAdmission\Registration_Result;
use App\Http\Models\ADM\StudentAdmission\Payment_Status;
use App\Http\Models\ADM\StudentAdmission\Exam_Type;
use App\Http\Models\ADM\StudentAdmission\Country;
use App\Http\Models\ADM\StudentAdmission\Province;
use App\Http\Models\ADM\StudentAdmission\District;
use App\Http\Models\ADM\StudentAdmission\Work_Type;
use App\Http\Models\ADM\StudentAdmission\Work_Income_Range;
use App\Http\Models\ADM\StudentAdmission\Certificate_Type;
use App\Http\Models\ADM\StudentAdmission\Document_Recomendation;
use App\Http\Models\ADM\StudentAdmission\Document_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Supporting;
use App\Http\Models\ADM\StudentAdmission\Document_Transcript;
use App\Http\Models\ADM\StudentAdmission\Document_Utbk;
use App\Http\Models\ADM\StudentAdmission\Education_Fund;
use App\Http\Models\ADM\StudentAdmission\ExcelModel\PostgraduateRegistration;
use App\Http\Models\ADM\StudentAdmission\Finpay_Sof_Id;
use App\Http\Models\ADM\StudentAdmission\Framework_Mapping_User_Role;
use App\Http\Models\ADM\StudentAdmission\Framework_User;
use App\Http\Models\ADM\StudentAdmission\Mapping_New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year;
use App\Http\Models\ADM\StudentAdmission\Mapping_Path_Year_Intake;
use App\Http\Models\ADM\StudentAdmission\Mapping_Report_Subject_Path;
use App\Http\Models\ADM\StudentAdmission\Mapping_Session_Study_Program;
use App\Http\Models\ADM\StudentAdmission\Mapping_Transcript_Participant;
use App\Http\Models\ADM\StudentAdmission\Mapping_Utbk_Path;
use App\Http\Models\ADM\StudentAdmission\ParticipantListExcel;
use App\Http\Models\ADM\StudentAdmission\ParticipantPaymentListExcel;
use App\Http\Models\ADM\StudentAdmission\ParticipantResultListExcel;
use App\Http\Models\ADM\StudentAdmission\MappingRegistrationProgramStudyListExcel;
use App\Http\Models\ADM\StudentAdmission\Moodle_Categories;
use App\Http\Models\ADM\StudentAdmission\Moodle_Courses;
use App\Http\Models\ADM\StudentAdmission\Moodle_Enrollments;
use App\Http\Models\ADM\StudentAdmission\Moodle_Groups;
use App\Http\Models\ADM\StudentAdmission\Moodle_Members;
use App\Http\Models\ADM\StudentAdmission\Moodle_Quizes;
use App\Http\Models\ADM\StudentAdmission\Moodle_Sections;
use App\Http\Models\ADM\StudentAdmission\Moodle_Users;
use App\Http\Models\ADM\StudentAdmission\New_Student;
use App\Http\Models\ADM\StudentAdmission\New_Student_Document_Type;
use App\Http\Models\ADM\StudentAdmission\New_Student_Step;
use App\Http\Models\ADM\StudentAdmission\Participant_Grade;
use App\Http\Models\ADM\StudentAdmission\Picklist;
use App\Http\Models\ADM\StudentAdmission\Pin_Voucher;
use App\Http\Models\ADM\StudentAdmission\Question_Answer;
use App\Http\Models\ADM\StudentAdmission\Registration_History;
use App\Http\Models\ADM\StudentAdmission\Selection_Category;
use App\Http\Models\ADM\StudentAdmission\Transaction_Request;
use App\Http\Models\ADM\StudentAdmission\Transaction_Result;
use App\Http\Models\ADM\StudentAdmission\Transaction_Voucher;
use App\Http\Models\ADM\StudentAdmission\ParticipantRegistrationExcel;
use App\Http\Models\ADM\StudentAdmission\Passing_Grade;
use App\Http\Models\ADM\StudentAdmission\Study_Program_Specialization;
use App\Http\Models\ADM\StudentAdmission\University;
use App\Http\Models\ADM\StudentAdmission\Publication_Type;
use App\Http\Models\ADM\StudentAdmission\Publication_Writer_Position;
use App\Http\Models\ADM\StudentAdmission\Document_Categories;
use App\Http\Models\ADM\StudentAdmission\Selection_Categories;
use App\Http\Models\ADM\StudentAdmission\Student_Interest;
use App\Http\Models\ADM\StudentAdmission\Category;
use App\Http\Models\ADM\StudentAdmission\Form;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Category;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Formulir;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Biaya;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Matapelajaran;
use App\Http\Models\ADM\StudentAdmission\Mapping_Prodi_Minat;
use App\Http\Models\ADM\StudentAdmission\Master_kelas;
use App\Http\Models\ADM\StudentAdmission\Master_Matpel;
use App\Http\Models\ADM\StudentAdmission\CBT_Package_Question_Users;
use App\Http\Models\ADM\StudentAdmission\Master_Package;
use App\Http\Models\ADM\StudentAdmission\Master_Package_Angsuran;
use App\Http\Models\ADM\StudentAdmission\Transfer_Credit;
use App\Http\Models\ADM\StudentAdmission\Schedule;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DataTables;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Schema;

class ReadController extends Controller
{
    public function LoginasParticipant(Request $request)
    {
        $by = $request->header("X-I");
        $data = $request->email;
        $email = str_replace("admisi-", "", $data);

        $data = Participant::GetParticipant($email);

        if ($data) {
            return response()->json($data, 200);
        } else {
            return response([
                'status' => 'Failed',
                'message' => 'Data not Found.'
            ], 404);
        }
    }

    public function GetSelectionProgram(Request $req)
    {

        $data = Selection_Programs::getSelectionProgram($req->active_status);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->addColumn('category', function ($row) {
                return $row->category;
            })
            ->make(true);
    }

    //function for getting selection path via admin
    public function GetSelectionPathAdmin(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path_id != '' || $req->selection_path_id == '0') {
            $selection_path_id = ['sp.id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['sp.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $datas = Selection_Path::select(
            'sp.id as selection_path_id',
            'sp.name',
            DB::raw('case when sp.active_status =' . "'t'" . ' then ' . "'1'" . ' else ' . "'0'" . ' end as active_status'),
            DB::raw('case when sp.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            'sp.exam_status as exam_status_id'
        )
            ->where([$selection_path_id, $active_status])
            ->orderBy('sp.id', 'DESC')
            ->get();

        $response = array();

        foreach ($datas as $key => $value) {
            if ($value['exam_status_id'] == 1) {
                $value['exam_status'] = "Raport";
            } else if ($value['exam_status_id'] == 2) {
                $value['exam_status'] = "CBT";
            } else {
                if ($value['exam_status_id'] == 0) {
                    $value['exam_status'] = null;
                } else {
                    $value['exam_status'] = Selection_Category::getCategoryName($value['exam_status_id'])->name;
                }
            }

            array_push($response, $value);
        }


        return response()->json($response, 200);
    }

    //function for getting selection path
    public function GetSelectionPathBackup(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path_id != '' || $req->selection_path_id == '0') {
            $selection_path_id = ['sp.id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['sp.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Selection_Path::select(
            'sp.id as selection_path_id',
            'sp.name',
            DB::raw('case when sp.active_status =' . "'t'" . ' then ' . "'1'" . ' else ' . "'0'" . ' end as active_status'),
            DB::raw('case when sp.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            'sp.exam_status as exam_status_id',
            DB::raw("CASE WHEN sp.exam_status = 1 then 'CBT' else 'Raport' end as exam_status")
        )
            ->leftjoin('exam_type as et', 'sp.exam_status', '=', 'et.id')
            ->where([$selection_path_id, $active_status])
            ->orderBy('sp.id', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    //function for getting selection path
    public function GetSelectionPath(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path_id != '' || $req->selection_path_id == '0') {
            $selection_path_id = ['sp.id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['mpy.id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['mapping_path_year_intake.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Mapping_Path_Year_Intake::select(
            'mapping_path_year_intake.id as mapping_path_year_intake_id',
            'mapping_path_year_intake.semester',
            DB::raw("case when mapping_path_year_intake.semester::int = 1 then 'GANJIL' else 'GENAP' end as semester_name"),
            'mapping_path_year_intake.school_year as mapping_path_year_intake_school_year',
            'mapping_path_year_intake.year as mapping_path_year_intake_year',
            'mapping_path_year_intake.notes',
            'mapping_path_year_intake.active_status',
            'mpy.id as mapping_path_year_id',
            'mpy.year',
            'mpy.school_year',
            'mpy.start_date',
            'mpy.end_date',
            'sp.id as selection_path_id',
            'sp.name as selection_path_name'
        )
            ->leftjoin('mapping_path_year as mpy', 'mapping_path_year_intake.mapping_path_year_id', '=', 'mpy.id')
            ->leftjoin('selection_paths as sp', 'mpy.selection_path_id', '=', 'sp.id')
            ->where([$mapping_path_year_id, $selection_path_id, $active_status])
            ->where('sp.active_status', '=', true)
            ->where('mpy.start_date', '<=', Carbon::now())
            ->where('mpy.end_date', '>=', Carbon::now())
            ->get();

        return response()->json($data, 200);
    }

    public function GetLocationExam(Request $req)
    {

        $data = Location_Exam::getLocationExam($req->filter, $req->active_status);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('location', function ($row) {
                return $row->location;
            })
            ->addColumn('city', function ($row) {
                return $row->city;
            })
            ->addColumn('city_id', function ($row) {
                return $row->city_id;
            })
            ->addColumn('address', function ($row) {
                return $row->address;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->make(true);
    }

    public function GetCity(Request $req)
    {
        $data = City_Region::GetCity($req->id, $req->province_id);
        return response()->json($data);
    }

    public function GetCities(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id != null) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', 1];
        }

        if ($req->province_id != null) {
            $province_id = ['province_id', '=', $req->province_id];
        } else {
            $province_id = [$filter, '=', 1];
        }

        try {
            $data = City_Region::select('city_regions.id', 'city_regions.detail_name as city', 'city_regions.province_id')
                ->join('provinces as p', 'city_regions.province_id', '=', 'p.id')
                ->join('countries as c', 'p.country_id', '=', 'c.id')
                ->where([$province_id, $id])
                ->where('c.id', '=', 1)
                ->orderBy('city_regions.detail_name')
                ->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 200);
        }
    }

    public function GetDocumentType(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->filter == null || $req->filter == "" || $req->filter == " ") {
            $nameFIlter = [$filter, '=', 1];
        } else {
            $nameFIlter = ['name', 'like', '%' . $req->filter . '%'];
        }

        if ($req->is_new_student) {
            if ($req->is_new_student == true) {
                $data = Document_Type::select(
                    'id',
                    'name',
                    'description'
                )
                    ->where([$nameFIlter])
                    ->whereIn('id', array(1, 2, 4, 5, 6, 7, 12, 29, 30, 31, 32, 33))
                    ->orderBy('id')
                    ->get();
            } else {
                $data = Document_Type::select(
                    'id',
                    'name',
                    'description'
                )
                    ->where([$nameFIlter])
                    ->whereNotIn('id', array(29, 30, 31, 32, 33))
                    ->orderBy('id')
                    ->get();
            }
        } else {
            $data = Document_Type::select(
                'id',
                'name',
                'description'
            )
                ->where([$nameFIlter])
                ->whereNotIn('id', array(29, 30, 31, 32, 33))
                ->orderBy('id')
                ->get();
        }

        return response()->json($data);
    }

    public function GetRegistrationStep(Request $req)
    {
        $data = Registration_Steps::GetRegistrationStep($req->filter);
        return response()->json($data);
    }

    public function ViewSelectionStep(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path_id || $req->selection_path_id == '0') {
            $selection_path_id = ['mp.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->selection_step_id || $req->selection_step_id == '0') {
            $selection_step_id = ['b.id', '=', $req->selection_step_id];
        } else {
            $selection_step_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['mp.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Mapping_Path_Step::select('mp.id', 'mp.selection_path_id', 'b.step', 'b.id as step_id', 'mp.ordering', 'mp.active_status', DB::raw('case when mp.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'))
            ->leftjoin('registration_steps as b', 'mp.registration_step_id', '=', 'b.id')
            ->where([$selection_path_id, $selection_step_id, $active_status])
            ->orderBy('mp.ordering', 'asc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('step', function ($row) {
                return $row->step;
            })
            ->addColumn('ordering', function ($row) {
                return $row->ordering;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->make(true);
    }

    public function ViewSelectionDocument(Request $req)
    {

        $filter = DB::raw('1');

        if ($req->selection_id != null) {
            $selection_path_id = ['md.selection_path_id', '=', $req->selection_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['md.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Mapping_Path_Document::select(
            'md.id',
            'md.selection_path_id',
            'b.name as document_name',
            'md.active_status',
            'md.document_type_id',
            'md.program_study_id',
            'c.study_program_branding_name as nama_prodi',
            DB::raw('case when md.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            DB::raw('case when md.required =' . "'t'" . ' then ' . "true" . ' else ' . "false" . ' end as required'),
            'md.is_value'
        )
            ->leftjoin('document_type as b', 'md.document_type_id', '=', 'b.id')
            ->leftjoin('study_programs as c', 'md.program_study_id', '=', 'c.classification_id')
            ->where([$selection_path_id, $active_status])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('document_name', function ($row) {
                return $row->document_name;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->make(true);
    }

    public function ViewSelectionPrice(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path_id != null) {
            $selection_path_id = ['mpp.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id != null) {
            $mapping_path_year_id = ['mpp.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['mpp.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        if ($req->id != null) {
            $price_id = ['mpp.id', '=', $req->id];
        } else {
            $price_id = [$filter, '=', 1];
        }

        if ($req->maks_study_program != null) {
            $maks_study_program = ['mpp.maks_study_program', '=', $req->maks_study_program];
        } else {
            $maks_study_program = [$filter, '=', 1];
        }

        $data = Mapping_Path_Price::select(
            'mpp.id',
            'mpp.selection_path_id',
            'mpp.price',
            'mpp.maks_study_program',
            'mpp.active_status',
            DB::raw('case when mpp.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            'mpp.mapping_path_year_id',
            'mpp.category as nama_formulir',
            'mpp.study_program_id',
            'b.study_program_branding_name as nama_prodi',
            'mpp.form_id',
            'c.name as kategori_formulir',
            'mpp.is_medical'
        )
            ->leftJoin('study_programs as b', 'mpp.study_program_id', '=', 'b.classification_id')
            ->leftJoin('forms as c', 'mpp.form_id', '=', 'c.id')
            ->where([$selection_path_id, $active_status, $price_id, $maks_study_program, $mapping_path_year_id])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('price', function ($row) {
                return (float) $row->price;
            })
            ->addColumn('maks_study_program', function ($row) {
                return $row->maks_study_program;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->make(true);
    }

    public function ViewMappingPathStudyProgram(Request $req)
    {
        $data = Mapping_Path_Study_Program::ViewMappingPathStudyProgram($req->selection_path_id, $req->active_status, $req->id, $req->is_technic);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('study_program_id', function ($row) {
                return $row->study_program_id;
            })
            ->addColumn('study_program_name', function ($row) {
                return $row->study_program_name;
            })
            ->addColumn('faculty_id', function ($row) {
                return $row->faculty_id;
            })
            ->addColumn('faculty_name', function ($row) {
                return $row->faculty_name;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->addColumn('quota', function ($row) {
                return $row->quota;
            })
            ->addColumn('minimum_donation', function ($row) {
                return $row->minimum_donation;
            })
            ->make(true);
    }

    public function ViewQuestionType()
    {
        $data = Question_Type::select('id', 'type', 'description')
            ->get();
        return response()->json($data);
    }

    public function ViewListQuisionare(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->filter_id) {
            $filter_id = ['quistionare.id', '=', $req->filter_id];
        } else {
            $filter_id = [$filter, '=', 1];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['quistionare.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['quistionare.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        // $query = '(select questionare_id, count (id) as question_total from questions GROUP BY questionare_id) as t1';
        $query = '(select questionare_id, count (id) as question_total from questions WHERE questions.question_type_id IS NOT NULL GROUP BY questionare_id) as t1';

        $data['data'] = Questionare::select(
            'quistionare.id',
            'quistionare.description',
            'quistionare.name',
            't1.question_total',
            DB::raw('count(question_answers.participant_id) as responden_total'),
            'quistionare.selection_path_id',
            'sp.name as selection_path_name',
            'quistionare.active_status',
            DB::raw('case when quistionare.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name')
        )
            ->leftjoin('questions', 'questions.questionare_id', '=', 'quistionare.id')
            ->leftjoin('question_answers', 'question_answers.question_id', '=', 'questions.id')
            ->leftjoin('selection_paths as sp', 'quistionare.selection_path_id', '=', 'sp.id')
            ->leftjoin(
                DB::raw($query),
                function ($join) {
                    $join->on('quistionare.id', '=', 't1.questionare_id');
                }
            )
            ->where([$filter_id, $selection_path_id, $active_status])
            ->groupBy('questions.questionare_id', 'quistionare.id', 'quistionare.name', 'quistionare.selection_path_id', 'sp.name', 'quistionare.active_status', 't1.question_total')
            ->orderBy('quistionare.id', 'asc')
            ->get();

        return response()->json($data);
    }

    public function ViewListQuestion(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->questionare_id) {
            $questionare_id = ['questionare_id', '=', $req->questionare_id];
        } else {
            $questionare_id = [$filter, '=', 1];
        }

        if ($req->question_id) {
            $question_id = ['questions.id', '=', $req->question_id];
        } else {
            $question_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['questions.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Question::select(
            'questions.id',
            'questions.detail',
            'questions.questionare_id',
            'questions.question_type_id',
            'qt.type as question_type_name',
            'questions.active_status',
            DB::raw('case when questions.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name')
        )
            ->join('question_type as qt', 'questions.question_type_id', '=', 'qt.id')
            ->where([$questionare_id, $question_id, $active_status])
            ->orderBy('id', 'asc')
            ->get();
        $detaildata = array();
        foreach ($data as $key => $value) {
            $detaildata[$key]['id'] = $value['id'];
            $detaildata[$key]['detail'] = $value['detail'];
            $detaildata[$key]['questionare_id'] = $value['questionare_id'];
            $detaildata[$key]['question_type_id'] = $value['question_type_id'];
            $detaildata[$key]['question_type_name'] = $value['question_type_name'];
            $detaildata[$key]['active_status'] = $value['active_status'];
            $detaildata[$key]['active_status_name'] = $value['active_status_name'];
            $detaildata[$key]['answer_options'] = Answer_Option::ViewListAnswer($value['id']);
        }
        return response()->json($detaildata, 200);
    }

    public function GetReligion(Request $req)
    {
        $data = Religion::GetReligion($req->filter);
        return response()->json($data);
    }

    public function GetNationality(Request $req)
    {
        $data = Nationality::getNationality($req->filter);
        return response()->json($data);
    }

    public function GetMarriageStatus(Request $req)
    {
        $data = Marriage_Status::getMarriageStatus($req->filter);
        return response()->json($data);
    }

    public function GetSchool(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->city_region_id) {
            $city_region_id = ['city_region_id', '=', $req->city_region_id];
        } else {
            $city_region_id = [$filter, '=', 1];
        }

        if ($req->education_degree_id) {
            $education_degree_id = ['schools.education_degree_id', '=', $req->education_degree_id];
        } else {
            $education_degree_id = [$filter, '=', 1];
        }

        if ($req->type == "he") {
            $data = University::select(
                'npsn as id',
                'detail_name as name',
                'address',
                'npsn',
                'city_region_id'
            )
                ->where([$city_region_id])
                ->get();
        } else {
            $data = School::select(
                'schools.id',
                'schools.name',
                'schools.address',
                'schools.npsn',
                'schools.city_region_id',
                'education_degree_id',
                'ed.level as education_degree_name'
            )
                ->leftjoin('education_degrees as ed', 'schools.education_degree_id', '=', 'ed.id')
                ->where([$city_region_id, $education_degree_id])
                ->orderBy('id')
                ->get();
        }

        return response()->json($data);
    }

    public function GetGender(Request $req)
    {
        $data = Gender::getGender($req->filter);
        return response()->json($data);
    }

    public function GetEducationDegree(Request $req)
    {
        $data = Education_Degree::getEducationDegree($req->filter);
        return response()->json($data);
    }

    public function getEducationMajor(Request $req)
    {
        $data = Education_Major::getEducationMajor($req->filter);
        return response()->json($data);
    }

    public function ViewParticipantEducationList(Request $req)
    {
        $university = "(select npsn, university from dblink( 'admission_masterdata','select npsn, detail_name as university from masterdata.public.universities') AS t1 ( npsn varchar, university varchar )) as bc";
        $cities = "(select id, detail_name from dblink('admission_masterdata', 'select id, detail_name as university from masterdata.public.city_regions') as t1 ( id integer, detail_name varchar )) as c";

        $data = Participant_Education::select(
            'participant_educations.id',
            'ed.level',
            DB::raw("CASE WHEN em.major IS NULL THEN participant_educations.education_major ELSE em.major END AS major"),
            DB::raw("case when participant_educations.npsn_he is not null then bc.university when school_id is not null then s.name else participant_educations.school end as school_name"),
            'participant_educations.graduate_year',
            's.id as school_id',
            'participant_educations.last_score',
            'participant_educations.student_id',
            'participant_educations.student_foreign',
            'ed.id as level_id',
            'em.id as education_major_id',
            'participant_educations.npsn_he',
            'ed.type',
            DB::raw("CASE WHEN s.city_region_id::integer IS NULL THEN participant_educations.city_id ELSE s.city_region_id::integer END AS city_region_id"),
            'c.detail_name as city_region'
        )
            ->leftjoin('schools as s', 'participant_educations.school_id', '=', 's.id')
            ->leftjoin('education_degrees as ed', 'participant_educations.education_degree_id', '=', 'ed.id')
            ->leftjoin('education_majors as em', 'participant_educations.education_major_id', '=', 'em.id')
            ->leftjoin(DB::raw($university), function ($join) {
                $join->on('participant_educations.npsn_he', '=', 'bc.npsn');
            })
            ->leftjoin(DB::raw($cities), function ($join) {
                $join->on(
                    DB::raw("CASE WHEN s.city_region_id::integer IS NULL THEN participant_educations.city_id ELSE s.city_region_id::integer END"),
                    '=',
                    'c.id'
                );
            })
            ->where('participant_educations.participant_id', '=', $req->participant_id)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('level', function ($row) {
                return $row->level;
            })
            ->addColumn('major', function ($row) {
                return $row->major;
            })
            ->addColumn('school_name', function ($row) {
                return $row->school_name;
            })
            ->addColumn('graduate_year', function ($row) {
                return $row->graduate_year;
            })
            ->make(true);
    }

    public function getFamilyRelationship(Request $req)
    {
        $data = Family_Relationship::getFamilyRelationship($req->filter);
        return response()->json($data);
    }

    public function ViewParticipantFamilyList(Request $req)
    {

        if ($req->category == 'parent') {
            $category = ['a.category', '=', 'parent'];
        } else {
            $category = ['a.category', '=', 'sibling'];
        }

        $participant_id = ['participant_families.participant_id', '=', $req->participant_id];

        $birth_city = '(select id, city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as city from masterdata.public.city_regions') AS t1 ( id integer, city varchar )) as bc";
        $address_country = '(select id, address_country from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_country from masterdata.public.countries') AS t1 ( id integer, address_country varchar )) as ac";
        $address_province = '(select id, address_province from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_province from masterdata.public.provinces') AS t1 ( id integer, address_province varchar )) as ap";
        $address_city = '(select id, address_city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_city from masterdata.public.city_regions') AS t1 ( id integer, address_city varchar )) as aci";
        $address_disctrict = '(select id, address_disctrict from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_disctrict from masterdata.public.districts') AS t1 ( id integer, address_disctrict varchar )) as ad";
        $gender = '(select id, gender from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id,gender from masterdata.public.gender') AS t1 ( id integer, gender varchar )) as gender";


        $data['data'] = Participant_Family::select('a.id as family_relationship_id', 'a.relationship', 'participant_families.family_name', 'participant_families.address_detail', 'participant_families.mobile_phone_number', 'participant_families.id', 'wf.id as work_field_id', 'wf.field as work_field', 'wt.id as work_type_id', 'wt.name as work_type_name', 'wi.id as work_income_range_id', 'wi.range as work_income_range', 'email', 'gender.id as gender', 'gender.gender as gender_name', 'bc.city as birth_city_name', 'bc.id as birth_city', 'birth_date', 'ac.address_country as address_country_name', 'ac.id as address_country', 'ap.address_province as address_province_name', 'ap.id as address_province', 'aci.address_city as address_city_name', 'aci.id as address_city', 'address_detail', 'address_postal_code', 'ad.id as address_disctrict_id', 'ad.address_disctrict', 'edu.id as education_degree', 'edu.level as education_degree_name', 'work_position', 'company_name')
            ->leftjoin('family_relationship as a', 'participant_families.family_relationship_id', '=', 'a.id')
            ->leftjoin('work_fields as wf', 'participant_families.work_field_id', '=', 'wf.id')
            ->leftjoin('work_types as wt', 'participant_families.work_type_id', '=', 'wt.id')
            ->leftjoin('work_income_range as wi', 'participant_families.work_income_range_id', '=', 'wi.id')
            ->leftjoin('education_degrees as edu', 'participant_families.education_degree_id', '=', 'edu.id')
            ->leftjoin(
                DB::raw($birth_city),
                function ($join) {
                    $join->on('participant_families.birth_place', '=', 'bc.id');
                }
            )
            ->leftjoin(
                DB::raw($address_country),
                function ($join) {
                    $join->on('participant_families.address_country', '=', 'ac.id');
                }
            )
            ->leftjoin(
                DB::raw($address_province),
                function ($join) {
                    $join->on('participant_families.address_province', '=', 'ap.id');
                }
            )
            ->leftjoin(
                DB::raw($address_city),
                function ($join) {
                    $join->on('participant_families.address_city', '=', 'aci.id');
                }
            )
            ->leftjoin(
                DB::raw($address_disctrict),
                function ($join) {
                    $join->on('participant_families.address_disctrict', '=', 'ad.id');
                }
            )
            ->leftjoin(
                DB::raw($gender),
                function ($join) {
                    $join->on('participant_families.gender', '=', 'gender.id');
                }
            )
            ->where([$category, $participant_id])
            ->get();

        return response()->json($data);
    }

    public function ViewListAnswerAll(Request $req)
    {
        $data = Questionare::select('quistionare.id as questionare_id', 'q.id as question_id', 'a.id as answer_option_id', 'a.value', 'a.ordering')
            ->leftjoin('questions as q', 'q.questionare_id', '=', 'quistionare.id')
            ->leftjoin('answer_options as a', 'a.question_id', '=', 'q.id')
            ->orderBy('q.id', 'asc')
            ->orderBy('a.ordering', 'asc')
            ->where('quistionare.id', '=', $req->questionare_id)
            ->get();
        return response()->json($data);
    }

    public function ViewWorkField(Request $req)
    {
        $data = Work_Field::select('id', 'field', 'description')
            ->get();
        return response()->json($data);
    }

    public function ViewParticipantWorkData(Request $req)
    {
        $data['data'] = Participant_Work_Data::select(
            'participant_work_data.id',
            'participant_work_data.company_name',
            'participant_work_data.work_position',
            'participant_work_data.work_start_date',
            'participant_work_data.work_end_date',
            'wf.id as work_field_id',
            'wf.field as work_field_name',
            'wt.id as work_type_id',
            'wt.name as work_type_name',
            'wir.id as work_income_range_id',
            'wir.range as work_income_range',
            'company_address',
            'company_phone_number'
        )
            ->leftjoin('work_fields as wf', 'participant_work_data.work_field_id', '=', 'wf.id')
            ->leftjoin('work_types as wt', 'participant_work_data.work_type_id', '=', 'wt.id')
            ->leftjoin('work_income_range as wir', 'participant_work_data.work_income_range_id', '=', 'wir.id')
            ->where('participant_work_data.participant_id', '=', $req->participant_id)
            ->get();
        // return DataTables::of($data)
        //     ->addIndexColumn()
        //     ->addColumn('id', function($row){
        //         return $row->id;
        //     })
        //     ->addColumn('company_name', function($row){
        //         return $row->company_name;
        //     })
        //     ->addColumn('work_position', function($row){
        //         return $row->work_position;
        //     })
        //     ->addColumn('work_start_date', function($row){
        //         return $row->work_start_date;
        //     })
        //     ->addColumn('work_end_date', function($row){
        //         return $row->work_end_date;
        //     })
        //     ->make(true);   

        return response()->json($data);
    }

    public function ViewParticipantDocument(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');

        $filter = DB::raw('1');

        if ($req->document_type_id) {
            $documettypeidfilter = ['document_type.id', '=', $req->document_type_id];
        } else {
            $documettypeidfilter = [$filter, '=', 1];
        }

        $data = Document_Type::select(
            'document_type.name as document_name',
            'document_type.id as document_type_id',
            'd.document_id as document_id',
            'd.participant_id',
            'd.id as participant_document_id',
            'd.url as document_url',
            $completeness_document,
            $document_status,
            'd.number',
            'd.approval_final_status'
        )
            ->leftjoin(
                DB::raw('(select 
                a.ID, 
                a.participant_id, 
                a.document_id, 
                b.document_type_id, 
                b.url, 
                b.number,
                b.approval_final_status 
                FROM participant_documents as a 
                join documents as b on (a.document_id = b.id) 
                WHERE a.participant_id = ' . $req->participant_id . ' ) d'),
                function ($join) {
                    $join->on('d.document_type_id', '=', 'document_type.id');
                }
            )
            ->where('document_type.type', '=', 'private')
            ->where([$documettypeidfilter])
            ->get();

        //return response()->json($data); 
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('document_name', function ($row) {
                return $row->document_name;
            })
            ->addColumn('document_type_id', function ($row) {
                return $row->document_type_id;
            })
            ->addColumn('document_url', function ($row) {
                return $row->document_url;
            })
            ->addColumn('document_id', function ($row) {
                return $row->document_id;
            })
            ->addColumn('participant_id', function ($row) {
                return $row->participant_id;
            })
            ->addColumn('approval_final_status', function ($row) {
                return $row->approval_final_status;
            })
            ->make(true);
    }

    public function ViewRegistrationList(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->participant_id) {
            $participant_id = ['registrations.participant_id', '=', $req->participant_id];
        } else {
            $participant_id = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->mapping_location_selection_id) {
            $mapping_location_selection_id = ['mls.id', '=', $req->mapping_location_selection_id];
        } else {
            $mapping_location_selection_id = [$filter, '=', 1];
        }

        $data = Registration::leftjoin('selection_paths as sp', 'sp.id', '=', 'registrations.selection_path_id')
            ->leftjoin('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
            ->leftjoin('payment_status as ps', 'registrations.payment_status_id', '=', 'ps.id')
            ->leftjoin('path_exam_details as pe', 'registrations.path_exam_detail_id', '=', 'pe.id')
            ->leftjoin('mapping_location_selection as mls', 'registrations.mapping_location_selection_id', '=', 'mls.id')
            ->leftjoin('location_exam as le', 'mls.location_exam_id', '=', 'le.id')
            ->leftjoin('mapping_path_price as mpp', 'registrations.mapping_path_price_id', '=', 'mpp.id')
            ->leftJoin('transaction_request as tr', 'registrations.registration_number', '=', 'tr.registration_number')
            ->leftJoin('registration_result as rr', 'registrations.registration_number', '=', 'rr.registration_number')
            ->select(
                'registrations.registration_number',
                'registrations.mapping_path_year_id',
                'sp.name as selection_path',
                'registrations.created_at',
                'registrations.payment_status_id',
                'registrations.payment_url as payment_receipt_url',
                DB::raw("CASE WHEN registrations.activation_pin = 'f' THEN CASE WHEN registrations.payment_url IS NOT NULL THEN 'In Progress' ELSE 'Belum Lunas' END WHEN registrations.activation_pin = 't' THEN 'Lunas' WHEN registrations.activation_pin IS NULL THEN CASE WHEN registrations.payment_url IS NOT NULL THEN 'In Progress' ELSE 'Belum Lunas' END END AS payment_receipt_status"),
                DB::raw("CASE WHEN registrations.activation_pin = 'f' THEN 2 WHEN registrations.activation_pin = 't' THEN 1 WHEN registrations.activation_pin IS NULL THEN 2 END AS payment_status_name"),
                'pm.method as payment_method',
                'pm.id as payment_method_id',
                'sp.id as selection_path_id',
                'pe.id as path_exam_detail_id',
                'le.id as exam_location_id',
                'le.location',
                'le.address',
                'mpp.id as mapping_path_price_id',
                DB::raw("to_char(mpp.price, 'FM999999999') as price"),
                'mpp.maks_study_program',
                'tr.virtual_account as payment_code',
                DB::raw("CASE WHEN rr.pass_status = 't' THEN 'Lulus' WHEN rr.pass_status = 'f' THEN 'Tidak Lulus' WHEN rr.pass_status IS NULL THEN '-' END AS pass_status"),
                'mls.id as mapping_location_selection_id',
                'sp.exam_status',
                'rr.transfer_status',
                'rr.transfer_program_study_id',
                'rr.specialization_id'
            )
            ->where([$participant_id, $registration_number, $mapping_location_selection_id])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('registration_number', function ($row) {
                return $row->registration_number;
            })
            ->addColumn('selection_path', function ($row) {
                return $row->selection_path;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('payment_status_id', function ($row) {
                return $row->payment_status_id;
            })
            ->addColumn('payment_status_name', function ($row) {
                return $row->payment_status_name;
            })
            ->addColumn('payment_method_id', function ($row) {
                return $row->payment_method_id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('selection_program_id', function ($row) {
                return $row->selection_program_id;
            })
            ->addColumn('price', function ($row) {
                return $row->price;
            })
            ->addColumn('maks_study_program', function ($row) {
                return $row->maks_study_program;
            })
            ->make(true);
    }

    public function GetPaymentMethod(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id != null) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = Payment_Method::select(
            'id',
            'method',
            'description'
        )
            ->where('active_status', '=', true)
            ->where([$id])
            ->get();

        return response()->json($data, 200);
    }

    public function ViewRegistrationProgramStudy(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->study_program_id != null) {
            $study_program_id = ['t1.classification_id', '=', $req->study_program_id];
        } else {
            $study_program_id = [$filter, '=', '1'];
        }

        $selection_path_id = Registration::select('selection_path_id')->where('registration_number', '=', $req->registration_number)->first();

        $query = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.id',
            'mapping_registration_program_study.priority',
            't1.study_program_branding_name as study_program_name',
            't1.classification_id as study_program_id',
            'mps.minimum_donation',
            't1.faculty_id',
            't1.faculty_name',
            'mps.id as mapping_path_program_study_id',
            'education_fund',
            'sps.classification_id',
            'sps.specialization_name',
            'sps.specialization_code',
            'sps.active_status as specialization_active_status',
            'sps.class_type',
            'mapping_registration_program_study.approval_faculty',
            'mapping_registration_program_study.approval_faculty_at',
            'mapping_registration_program_study.approval_faculty_by',
            'mapping_registration_program_study.rank'
        )
            ->leftjoin('mapping_path_program_study as mps', 'mapping_registration_program_study.program_study_id', '=', 'mps.program_study_id')
            ->leftjoin('study_programs as t1', 'mapping_registration_program_study.program_study_id', '=', 't1.classification_id')
            ->leftjoin('study_program_specializations as sps', 'mapping_registration_program_study.study_program_specialization_id', '=', 'sps.id')

            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->where('mps.selection_path_id', '=', $selection_path_id->selection_path_id)
            ->where([$study_program_id])
            ->where('mps.active_status', '=', true)
            ->orderBy('mapping_registration_program_study.priority')
            ->get();

        $data['data'] = array();

        foreach ($query as $key => $value) {
            $value['sdp_total'] = number_format($value['price'] + $value['education_fund'] + $value['minimum_donation'], 0, '.', '.');
            array_push($data['data'], $value);
        }

        return response()->json($data, 200);
    }

    public function GetStudyProgram(Request $req)
    {
        //ambil semua id program study yang terdaftar didatabase dan masukkan ke dalam listtag
        $mappings = Mapping_Path_Study_Program::select(
            DB::raw("string_agg(distinct msp.program_study_id::varchar, ',') as ids")
        )
            ->where('msp.selection_path_id', '=', $req->selection_path_id)
            ->where('msp.active_status', '=', true)
            ->first();

        //hasil dari $mappings = "1,2,4,5,6,9,12"
        //ubah bentuk string listag menjadi array integer
        $mappingIds = array_map('intval', explode(',', $mappings->ids));

        $filter = DB::raw('1');

        if ($req->faculty_id != '' && $req->faculty_id != '0') {
            $faculty_id = ['study_programs.faculty_id', '=', $req->faculty_id];
        } else {
            $faculty_id = [$filter, '=', 1];
        }

        if ($req->study_program_id) {
            $study_program_id = ['study_programs.classification_id', '=', $req->study_program_id];
        } else {
            $study_program_id = [$filter, '=', 1];
        }

        $data = Study_Program::select(
            'study_programs.classification_id as id',
            'study_program_branding_name as study_program_name',
            'study_program_name_en',
            'study_programs.acronim',
            'study_programs.faculty_id',
            'study_programs.faculty_name',
            'study_programs.quota'
        )
            ->where([$faculty_id, $study_program_id])
            ->orderBy('study_program_name');

        if ($req->show_all != null) {
            if ($req->show_all == 1) {
                $result = $data->get();
            } else {
                $result = $data->whereNotIn('study_programs.classification_id', $mappingIds)->get();
            }
        } else {
            $result = $data->whereNotIn('study_programs.classification_id', $mappingIds)->get();
        }

        return $result;
    }

    public function GetSemester()
    {
        $data = Semester::GetSemester();
        return response()->json($data);
    }

    public function GetRangeScore()
    {
        $data = Range_Score::GetRangeScore();
        return response()->json($data);
    }

    public function GetDocumentReportCard(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');

        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->document_type_id) {
            $document_type_id = ['d.document_type_id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', 1];
        }

        if ($req->document_report_card_id) {
            $document_report_card_id = ['document_report_card.id', '=', $req->document_report_card_id];
        } else {
            $document_report_card_id = [$filter, '=', 1];
        }

        $data['data'] = Document_Report_Card::select(
            'semester_id',
            's.name as semesters',
            'r.name as range_scores',
            'range_score',
            'math',
            'physics',
            'bahasa',
            'english',
            'biology',
            'economy',
            'geography',
            'sociological',
            'historical',
            'chemical',
            'gpa',
            'document_report_card.id as document_report_card_id',
            'd.url',
            $completeness_document,
            $document_status,
            'd.id as document_id'
        )
            ->join('documents as d', 'document_report_card.document_id', '=', 'd.id')
            ->leftjoin('semesters as s', 'document_report_card.semester_id', '=', 's.id')
            ->leftjoin('range_scores as r', 'document_report_card.range_score', '=', 'r.id')
            ->where([$registration_number, $document_type_id, $document_report_card_id])
            ->orderBy('s.id', 'asc')
            ->get();
        return response()->json($data);
    }

    public function GetCertificateLevel()
    {
        $data = Certificate_Level::GetCertificateLevel();
        return response()->json($data);
    }

    public function GetDocumentCertificate(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');

        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['document_certificate.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }
        if ($req->certificate_type) {
            $certificate_type = ['document_certificate.certificate_type_id', '=', $req->certificate_type];
        } else {
            $certificate_type = [$filter, '=', 1];
        }


        if ($req->document_certificate_id) {
            $document_certificate_id = ['document_certificate.id', '=', $req->document_certificate_id];
        } else {
            $document_certificate_id = [$filter, '=', 1];
        }

        $data['data'] = Document_Certificate::select(
            'document_certificate.id as document_certificate_id',
            'cl.type as certificate_level',
            'cl.id as certificate_level_id',
            'ct.type as certificate_type',
            'ct.id as certificate_type_id',
            'd.id as document_id',
            'd.name as certificate_name',
            'document_certificate.certificate_score',
            'document_certificate.publication_year',
            'd.description',
            'd.number as document_certificate_number',
            'd.url as certificate_url',
            $completeness_document,
            $document_status,
            'document_certificate.registration_number'
        )
            ->leftjoin('certificate_levels as cl', 'document_certificate.certificate_level_id', '=', 'cl.id')
            ->leftjoin('certificate_type as ct', 'document_certificate.certificate_type_id', '=', 'ct.id')
            ->leftjoin('documents as d', 'document_certificate.document_id', '=', 'd.id')
            ->where([$registration_number, $certificate_type, $document_certificate_id])
            ->orderBy('d.id', 'asc')
            ->get();
        return response()->json($data);
    }

    public function GetDocumentSupporting(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');

        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->document_type_id) {
            $document_type_id = ['d.document_type_id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', 1];
        }

        $data['data'] = Document_Supporting::select(
            'document_supporting.id as document_supporting_id',
            'document_id',
            'pic_name',
            'pic_phone_number',
            $completeness_document,
            $document_status,
            'd.name as document_name',
            'd.document_type_id',
            'pic_email_address',
            'pic_address',
            'd.description',
            'd.number as document_certificate_number',
            'd.url as supporting_url',
            'registration_number'
        )
            ->leftjoin('documents as d', 'document_id', '=', 'd.id')
            ->where([$registration_number, $document_type_id])
            ->orderBy('d.id', 'asc')
            ->get();
        return response()->json($data);
    }

    public function GetDocumentStudy(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');

        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['document_study.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->document_study_id) {
            $document_study_id = ['document_study.id', '=', $req->document_study_id];
        } else {
            $document_study_id = [$filter, '=', 1];
        }

        if ($req->document_type_id) {
            $document_type_id = ['d.document_type_id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', 1];
        }

        $data['data'] = Document_Study::select(
            'd.id as document_id',
            'd.name as document_name',
            'd.document_type_id',
            'd.description as document_description',
            'd.number as document_number',
            'd.url as document_url',
            'document_study.id as document_study_id',
            'document_study.score as score',
            'document_study.registration_number',
            'document_study.year',
            'title',
            $completeness_document,
            $document_status
        )
            ->leftjoin('documents as d', 'document_study.document_id', '=', 'd.id')
            ->where([$registration_number, $document_study_id, $document_type_id])
            ->orderBy('d.id', 'asc')
            ->get();

        return response()->json($data);
    }

    public function GetLocationSelection(Request $req)
    {
        $subquery = '(select id, city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as city from masterdata.public.city_regions') AS t1 ( id INT, city varchar )) as ct";

        //filter active status
        $filter = DB::raw('1');

        if ($req->active_status) {
            $active_status = ['mapping_location_selection.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        $data = Mapping_Location_Selection::select(
            'mapping_location_selection.id',
            'mapping_location_selection.selection_path_id',
            'mapping_location_selection.location_exam_id',
            'mapping_location_selection.active_status',
            'le.location',
            'le.address',
            'ct.city',
            DB::raw('case when mapping_location_selection.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name')
        )
            ->join('location_exam as le', 'mapping_location_selection.location_exam_id', '=', 'le.id')
            ->join(
                DB::raw($subquery),
                function ($join) {
                    $join->on('le.city', '=', 'ct.id');
                }
            )
            ->where('mapping_location_selection.selection_path_id', '=', $req->selection_path_id)
            ->where([$active_status])
            ->orderBy('mapping_location_selection.id', 'asc')
            ->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('location_exam_id', function ($row) {
                return $row->location_exam_id;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->addColumn('location', function ($row) {
                return $row->location;
            })
            ->addColumn('address', function ($row) {
                return $row->address;
            })
            ->addColumn('city', function ($row) {
                return $row->city;
            })
            ->make(true);
    }

    public function GetPathExamDetail(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['path_exam_details.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        if ($req->exam_location_id) {
            $exam_location_id = ['le.id', '=', $req->exam_location_id];
        } else {
            $exam_location_id = [$filter, '=', 1];
        }

        if ($req->active_status) {
            $active_status = ['path_exam_details.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', 1];
        }

        if ($req->exam_type_id) {
            $exam_type_id = ['path_exam_details.exam_type_id', '=', $req->exam_type_id];
        } else {
            $exam_type_id = [$filter, '=', 1];
        }

        $data = Path_Exam_Detail::select(
            'path_exam_details.id',
            'selection_path_id',
            DB::raw('TO_CHAR(exam_start_date,' . "'YYYY-MM-DD'" . ') as exam_date'),
            DB::raw('CONCAT(TO_CHAR(exam_start_date, ' . "'HH24:MI:SS'" . '),' . "' - '" . ',TO_CHAR(exam_end_date, ' . "'HH24:MI:SS'" . ')) as exam_hour'),
            'path_exam_details.active_status',
            DB::raw('case when path_exam_details.active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'),
            DB::raw('CONCAT(TO_CHAR(exam_start_date, ' . "'HH24:MI:SS'" . ')) as exam_start_date'),
            DB::raw('CONCAT(TO_CHAR(exam_end_date, ' . "'HH24:MI:SS'" . ')) as exam_end_date'),
            'exam_start_date as origin_start_date',
            'exam_end_date as origin_end_date',
            'path_exam_details.quota',
            'path_exam_details.session_one_start',
            'path_exam_details.session_two_start',
            'path_exam_details.session_three_start',
            'path_exam_details.session_one_end',
            'path_exam_details.session_two_end',
            'path_exam_details.session_three_end',
            'path_exam_details.exam_type_id',
            'path_exam_details.class_type',
            'le.city',
            'le.location',
            'le.address',
            'path_exam_details.exam_type_id',
            'et.name as exam_type',
            DB::raw("TO_CHAR(exam_start_date, 'YYYY FMMM') as exam_month_year")
        )
            ->leftjoin('location_exam as le', 'path_exam_details.exam_location_id', '=', 'le.id')
            ->leftjoin('exam_type as et', 'path_exam_details.exam_type_id', '=', 'et.id')
            ->where([$selection_path_id, $exam_location_id, $active_status, $exam_type_id, $id])
            ->orderBy('path_exam_details.id', 'asc')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('exam_date', function ($row) {
                return $row->exam_date;
            })
            ->addColumn('exam_hour', function ($row) {
                return $row->exam_hour;
            })
            ->addColumn('active_status', function ($row) {
                return $row->active_status;
            })
            ->addColumn('active_status_name', function ($row) {
                return $row->active_status_name;
            })
            ->addColumn('exam_start_date', function ($row) {
                return $row->exam_start_date;
            })
            ->addColumn('exam_end_date', function ($row) {
                return $row->exam_end_date;
            })
            ->addColumn('origin_start_date', function ($row) {
                return $row->origin_start_date;
            })
            ->addColumn('origin_end_date', function ($row) {
                return $row->origin_end_date;
            })
            ->make(true);
    }

    public function ViewParticipantList(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->program) {
            $program = ['sp.selection_program_id', '=', $req->program];
        } else {
            $program = [$filter, '=', 1];
        }

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }


        if ($req->nationality) {
            $nationality = ['p.nationality', '=', $req->nationality];
        } else {
            $nationality = [$filter, '=', 1];
        }


        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }


        $regist_history = DB::raw('(select max(registration_step_id) as registration_step_id, registration_number from registration_history group by registration_number) as rh');

        $pass_status = DB::raw('case when rr.pass_status = ' . "'f'" . ' then ' . "'Tidak Lulus'" . ' when rr.pass_status = ' . "'t'" . ' then ' . "'Lulus'" . ' else ' . "'Belum Ditentukan'" . ' end as pass_status_name');
        $data = Registration::select(
            'registrations.registration_number',
            'rs.step as registration_step',
            'sp.name as selection_path_name',
            'sp.id as selection_path_id',
            'ps.status as payment_status',
            $pass_status,
            'p.id as participant_id',
            'rr.pass_status',
            'p.fullname',
            'p.username as email',
            'p.mobile_phone_number',
            'rr.transfer_status',
            'rr.transfer_program_study_id'
        )
            ->leftjoin(
                DB::raw($regist_history),
                function ($join) {
                    $join->on('rh.registration_number', '=', 'registrations.registration_number');
                }
            )
            ->leftjoin('registration_steps as rs', 'rh.registration_step_id', '=', 'rs.id')
            ->leftjoin('payment_status as ps', 'registrations.payment_status_id', '=', 'ps.id')
            ->leftjoin('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('registration_result as rr', 'registrations.registration_number', '=', 'rr.registration_number')
            ->where([$program, $selection_path, $nationality, $registration_number])
            ->orderBy('registrations.registration_number')
            ->distinct()
            ->get();
        //return response()->json($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('registration_number', function ($row) {
                return $row->registration_number;
            })
            ->addColumn('registration_step', function ($row) {
                return $row->registration_step;
            })
            ->addColumn('selection_path_name', function ($row) {
                return $row->selection_path_name;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('payment_status', function ($row) {
                return $row->payment_status;
            })
            ->addColumn('participant_id', function ($row) {
                return $row->participant_id;
            })
            ->addColumn('fullname', function ($row) {
                return $row->fullname;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('mobile_phone_number', function ($row) {
                return $row->mobile_phone_number;
            })
            ->make(true);
    }

    public function ViewParticipantPaymentList(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->payment_status) {
            $payment_status = ['registrations.payment_status_id', '=', $req->payment_status];
        } else {
            $payment_status = [$filter, '=', 1];
        }

        if ($req->payment_method) {
            $payment_method = ['registrations.payment_method_id', '=', $req->payment_method];
        } else {
            $payment_method = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        $data = Registration::select(
            'registrations.registration_number',
            'sp.name as selection_path_name',
            'sp.id as selection_path_id',
            'mpp.price',
            'ps.status as payment_status_name',
            'ps.id as payment_status',
            // DB::raw("CASE WHEN registrations.activation_pin = 'f' THEN 'Belum Lunas' WHEN registrations.activation_pin = 't' THEN 'Lunas' WHEN registrations.activation_pin IS NULL THEN 'Belum Lunas' END AS payment_status_name"),
            // DB::raw("CASE WHEN registrations.activation_pin = 'f' THEN 2 WHEN registrations.activation_pin = 't' THEN 1 WHEN registrations.activation_pin IS NULL THEN 2 END AS payment_status"),
            'registrations.payment_url',
            'pm.method as payment_method_name',
            'pm.id as payment_method',
            'registrations.activation_pin',
            'registrations.mapping_path_year_id'
        )
            ->leftjoin('payment_methods as pm', 'pm.id', '=', 'registrations.payment_method_id')
            ->leftjoin('payment_status as ps', 'registrations.payment_status_id', '=', 'ps.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('mapping_path_price as mpp', 'mpp.id', '=', 'registrations.mapping_path_price_id')
            ->leftjoin('mapping_path_year as mpy', 'registrations.mapping_path_year_id', 'mpy.id')
            ->where([$selection_path, $payment_status, $payment_method, $registration_number, $mapping_path_year_id])
            ->orderBy('registrations.registration_number')
            ->distinct()
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('registration_number', function ($row) {
                return $row->registration_number;
            })
            ->addColumn('selection_path_name', function ($row) {
                return $row->selection_path_name;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('price', function ($row) {
                return number_format($row->price, 0, '.', '.');
            })
            ->addColumn('payment_status', function ($row) {
                return $row->payment_status;
            })
            ->addColumn('payment_url', function ($row) {
                return $row->payment_url;
            })
            ->make(true);
    }

    public function GetFaculty(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id != null) {
            $id = ['faculty_id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = Study_Program::select(
            'faculty_id as id',
            'faculty_name',
            'acronim'
        )
            ->distinct()
            ->orderBy('faculty_id')
            ->where([$id])
            ->get();

        return response()->json($data, 200);
    }

    //api untuk menampilkan list study program
    public function ViewStudyPrograms(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->faculty_id != '' && $req->faculty_id != '0') {
            $faculty_id = ['study_programs.faculty_id', '=', $req->faculty_id];
        } else {
            $faculty_id = [$filter, '=', 1];
        }

        if ($req->study_program_id) {
            $study_program_id = ['study_programs.classification_id', '=', $req->study_program_id];
        } else {
            $study_program_id = [$filter, '=', 1];
        }

        $data = Study_Program::select(
            'study_programs.classification_id as id',
            'study_program_branding_name as study_program_name',
            'study_program_name_en',
            'study_programs.acronim',
            'study_programs.faculty_id',
            'study_programs.faculty_name'
        )
            ->where([$faculty_id, $study_program_id])
            ->orderBy('study_program_branding_name')
            ->get();

        return response()->json($data, 200);
    }

    public function ViewListDocumentRegistration(Request $req)
    {
        $completeness_document = DB::raw('case when d.url is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as completeness_document');
        $document_status = DB::raw('case when d.approval_final_status = ' . "'1'" . 'and d.url is not null then ' . "'approved'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is null then ' . "'-'" . ' when (d.approval_final_status <> ' . "'1'" . ' or d.approval_final_status is null) and d.url is not null then ' . "'waiting for approved'" . ' end as document_status');
        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->document_type_id) {
            $document_type_id = ['dt.id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', 1];
        }

        $data = Registration::select(
            'registrations.registration_number',
            'dt.name as document_type',
            $completeness_document,
            $document_status,
            'dt.id as document_type_id',
            'd.id as document_id',
            'd.url as document_url',
            'd.approval_final_status as document_status_id',
            'd.description as document_description'
        )
            ->join('participant_documents as pd', 'registrations.participant_id', '=', 'pd.participant_id')
            ->join('documents as d', 'pd.document_id', '=', 'd.id')
            ->join('document_type as dt', 'd.document_type_id', '=', 'dt.id')
            ->where([$registration_number, $document_type_id])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('registration_number', function ($row) {
                return $row->registration_number;
            })
            ->addColumn('document_type', function ($row) {
                return $row->document_type;
            })
            ->addColumn('completeness_document', function ($row) {
                return $row->completeness_document;
            })
            ->addColumn('document_status', function ($row) {
                return $row->document_status;
            })
            ->addColumn('document_type_id', function ($row) {
                return $row->document_type_id;
            })
            ->addColumn('document_id', function ($row) {
                return $row->document_id;
            })
            ->addColumn('document_url', function ($row) {
                return $row->document_url;
            })
            ->addColumn('document_status_id', function ($row) {
                return $row->document_status_id;
            })
            ->addColumn('document_description', function ($row) {
                return $row->document_description;
            })
            ->make(true);
    }

    public function ListSelectionResult(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        $data = Registration::select(
            'sp.id as selection_path_id',
            'sp.name as selection_path_name',
            DB::raw('count(registrations.registration_number) as total_participant')
        )
            ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->where([$selection_path])
            ->groupBy('sp.id', 'sp.name')
            ->get();
        //return response()->json($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('selection_path_name', function ($row) {
                return $row->selection_path_name;
            })
            ->addColumn('total_participant', function ($row) {
                return $row->total_participant;
            })
            ->make(true);
    }

    public function GetParticipantDetail(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->participant_id) {
            $participant_id = ['participants.id', '=', $req->participant_id];
        } else {
            $participant_id = [$filter, '=', 1];
        }

        if ($req->username) {
            $username = [DB::raw("lower(participants.username)"), '=', str_replace('%20', ' ', strtolower($req->username))];
        } else {
            $username = [$filter, '=', 1];
        }

        if ($req->is_header) {
            $by = $req->header("X-I");
            $user = Framework_User::select('id', 'username')->where('id', '=', $by)->first();
            $username = [DB::raw("lower(participants.username)"), '=', str_replace('%20', ' ', strtolower($user->username))];
        }

        $data = Participant::select(
            'participants.fullname',
            'participants.telutizen_status',
            'participants.telutizen_student_id',
            'participants.gender',
            'participants.religion',
            'participants.birth_city',
            'participants.birth_province',
            'participants.birth_country',
            'birth_date',
            'participants.nationality',
            'participants.origin_country',
            'participants.identify_number',
            'participants.passport_number',
            'participants.passport_expiry_date',
            'participants.marriage_status',
            'children_total',
            'participants.address_country',
            'participants.address_province',
            'participants.address_city',
            'participants.address_disctrict',
            'address_detail',
            'address_postal_code',
            'house_phone_number',
            'mobile_phone_number',
            'participants.id as participant_id',
            'participants.username',
            'participants.photo_url',
            DB::raw("CASE WHEN participants.color_blind IS NULL THEN 'Tidak' ELSE participants.color_blind END AS color_blind"),
            'participants.special_needs',
            'participants.birth_province_foreign',
            'participants.birth_city_foreign',
            'participants.nis',
            'participants.nisn'
        )
            ->where([$username, $participant_id])
            ->where('participants.isverification', '=', true)
            ->first();


        if (isset($data->passport_number)) {
            $data['passport_number'] = $data->passport_number;
        } else {
            $data['passport_number'] = '-';
        }

        if (isset($data->fullname)) {
            $data['firstname'] = Participant::GenerateFirstLastNameFromFullname($data->fullname)['firstname'];
            $data['lastname'] = Participant::GenerateFirstLastNameFromFullname($data->fullname)['lastname'];
        } else {
            $data['firstname'] = "-";
            $data['lastname'] = '-';
        }

        if (isset($data->passport_expiry_date)) {
            $data['passport_expiry_date'] = Carbon::parse($data->passport_expiry_date)->format('Y-m-d');
        } else {
            $data['passport_expiry_date'] = '-';
        }

        if (isset($data->gender)) {
            $data['gender_name'] = Gender::getGenderName($data->gender)->gender;
        } else {
            $data['gender_name'] = '';
        }

        if (isset($data->religion)) {
            $data['religion_name'] = Religion::getReligionName($data->religion)->religion;
        } else {
            $data['religion_name'] = '';
        }

        if (isset($data->birth_city)) {
            $data['birth_city_name'] = City_Region::GetCityName($data->birth_city)->city;
        } else {
            if (isset($data->birth_city_foreign)) {
                $data['birth_city_name'] = $data->birth_city_foreign;
            } else {
                $data['birth_city_name'] = '';
            }
        }

        if (isset($data->birth_province)) {
            $data['birth_province_name'] = Province::GetProvinceName($data->birth_province)->detail_name;
        } else {
            if (isset($data->birth_province_foreign)) {
                $data['birth_province_name'] = $data->birth_province_foreign;
            } else {
                $data['birth_province_name'] = '';
            }
        }

        if (isset($data->origin_country)) {
            $data['origin_country_name'] = Country::GetCountryName($data->origin_country)->detail_name;
        } else {
            $data['origin_country_name'] = '';
        }

        if (isset($data->birth_country)) {
            $data['birth_country_name'] = Country::GetCountryName($data->birth_country)->detail_name;
        } else {
            $data['birth_country_name'] = '';
        }

        if (isset($data->nationality)) {
            $data['nationality_name'] = Nationality::getNationalityName($data->nationality)->nationality;
        } else {
            $data['nationality_name'] = '';
        }

        if (isset($data->address_city)) {
            $data['address_city_name'] = City_Region::GetCityName($data->address_city)->city;
        } else {
            $data['address_city_name'] = '';
        }

        if (isset($data->address_province)) {
            $data['address_province_name'] = Province::GetProvinceName($data->address_province)->detail_name;
        } else {
            $data['address_province_name'] = '';
        }

        if (isset($data->address_disctrict)) {
            $data['address_disctrict_name'] = District::GetDistrictName($data->address_disctrict)->detail_name;
        } else {
            $data['address_disctrict_name'] = '';
        }

        if (isset($data->address_country)) {
            $data['address_country_name'] = Country::GetCountryName($data->address_country)->detail_name;
        } else {
            $data['address_country_name'] = '';
        }

        return response()->json($data);
    }

    public function ListSelectionResultDetail(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registration_result.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->participant_id) {
            $participant_id = ["registrations.participant_id", "=", $req->participant_id];
        } else {
            $participant_id = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        $pass_status =  DB::raw('case when registration_result.pass_status = ' . "'f'" . ' and now() >= publication_date then ' . "'Tidak Lulus'" . ' when registration_result.pass_status = ' . "'t'" . ' and now() >= publication_date then ' . "'Lulus'" . ' else ' . "'Belum Ditentukan'" . ' end as pass_status_name');

        $data = Registration::select(
            'registrations.participant_id',
            'sp.id as selection_path_id',
            'sp.name as selection_path_name',
            'registrations.registration_number',
            'registration_result.total_score',
            $pass_status,
            'registration_result.pass_status',
            'registration_result.publication_status',
            'registration_result.publication_date',
            'registration_result.schoolarship_id',
            'registration_result.spp',
            'registration_result.bpp',
            'registration_result.lainnya',
            'registration_result.ujian',
            'registration_result.praktikum',
            'registration_result.bppdiscount',
            'registration_result.sppdiscount',
            'registration_result.discount',
            'registration_result.semester',
            'registration_result.sks',
            'registration_result.notes',
            'registration_result.start_date_1',
            'registration_result.start_date_2',
            'registration_result.start_date_3',
            'registration_result.end_date_1',
            'registration_result.end_date_2',
            'registration_result.end_date_3',
            'registration_result.schoolyear',
            'registration_result.type',
            'registration_result.oldstudentid',
            'registration_result.reference_number',
            'registration_result.password',
            'registration_result.transfer_status',
            'registration_result.transfer_program_study_id',
            'registration_result.council_date',
            'approval_university',
            'approval_university_by',
            'registration_result.approval_university_at',
            'registration_result.generated_at',
            'registration_result.file_url',
            'registration_result.specialization_id',
            'registration_result.package_id',
            'registration_result.payment_method_id',
            'registration_result.payment_status',
            'tps.study_program_branding_name as transfer_program_study_name',
            'tps.faculty_name as transfer_faculty_name',
            'registration_result.program_study_id as study_program_id',
            'ps.study_program_branding_name as study_program_name',
            'ps.faculty_name as faculty_name',
            'registrations.mapping_path_year_id'
        )
            ->leftjoin('registration_result', 'registration_result.registration_number', '=', 'registrations.registration_number')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('study_programs as ps', 'registration_result.program_study_id', '=', 'ps.classification_id')
            ->leftjoin('study_programs as tps', 'registration_result.transfer_program_study_id', '=', 'tps.classification_id')
            ->where([$selection_path, $registration_number, $participant_id, $mapping_path_year_id])
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('participant_id', function ($row) {
                return $row->participant_id;
            })
            ->addColumn('selection_path_id', function ($row) {
                return $row->selection_path_id;
            })
            ->addColumn('selection_path_name', function ($row) {
                return $row->selection_path_name;
            })
            ->addColumn('registration_number', function ($row) {
                return $row->registration_number;
            })
            ->addColumn('total_score', function ($row) {
                return $row->total_score;
            })
            ->addColumn('pass_status', function ($row) {
                return $row->pass_status;
            })
            ->addColumn('result_id', function ($row) {
                return $row->result_id;
            })
            ->addColumn('mapping_registration_program_study', function ($row) {
                return $row->mapping_registration_program_study_id;
            })
            ->addColumn('study_program_name', function ($row) {
                return $row->study_program_name;
            })
            ->make(true);
    }

    public function GetPaymentStatus()
    {
        $data = Payment_Status::GetPaymentStatus();
        return response()->json($data);
    }

    public static function ViewListAnswer(Request $req)
    {
        $filter = DB::raw('1');
        if ($req->question_id) {
            $question_id = ['question_id', '=', $req->question_id];
        } else {
            $question_id = [$filter, '=', 1];
        }

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', 1];
        }

        $data = Answer_Option::select('id', 'question_id', 'value', 'ordering')
            ->where([$question_id, $id])
            ->orderBy('ordering', 'asc')
            ->get();
        return $data;
    }

    public function GetExamType()
    {
        $data = Exam_Type::GetExamType();
        return response()->json($data);
    }

    public function GetCountry(Request $req)
    {
        $data = Country::GetCountry($req->id);
        return response()->json($data);
    }

    public function GetProvince(Request $req)
    {
        $data = Province::GetProvince($req->id, $req->country_id);
        return response()->json($data);
    }

    public function GetDistrict(Request $req)
    {
        $data = District::GetDistrict($req->id, $req->city_region_id);
        return response()->json($data);
    }

    public function GetWorkType(Request $req)
    {
        if ($req->is_productive != '') {
            $data = Work_Type::select('id', 'name', 'description', 'is_productive')
                ->where('is_productive', '=', $req->is_productive)
                ->orderBy('id', 'asc')
                ->get();
        } else {
            $data = Work_Type::select('id', 'name', 'description', 'is_productive')
                ->orderBy('id', 'asc')
                ->get();
        }
        return response()->json($data);
    }

    public function GetWorkIncomeRange(Request $req)
    {
        $data = Work_Income_Range::select('id', 'range')
            ->orderBy('id', 'asc')
            ->get();
        return response()->json($data);
    }

    public static function GetRegistrationExamDetail(Request $req)
    {
        $filter = DB::raw('1');
        if ($req->registration_number) {
            $registration_number = ['', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->selection_path_id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', 1];
        }

        $data = Answer_Option::select('id', 'question_id', 'value', 'ordering')
            ->where([$question_id, $id])
            ->orderBy('ordering', 'asc')
            ->get();
        return $data;
    }

    public function GetCertificateType()
    {
        $data = Certificate_Type::GetCertificateType();
        return response()->json($data);
    }

    public function RegistrationCard(Request $request)
    {
        //get participant list program study choose
        $listprodi = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.id',
            'mapping_registration_program_study.priority',
            'sp.study_program_branding_name as study_program_name',
            'sp.classification_id as study_program_id',
            'mps.minimum_donation',
            'sp.faculty_id',
            'sp.faculty_name',
            'mps.id as mapping_path_program_study_id',
            'education_fund',
            'mapping_registration_program_study.study_program_specialization_id',
            'sps.specialization_name as specialization_name_ori',
            DB::raw('CONCAT(sps.specialization_name,CONCAT(' . "' - '" . ', sps.class_type)) AS specialization_name'),
            'sps.specialization_code',
            'sps.active_status',
            'sps.class_type'
        )
            ->leftjoin('mapping_path_program_study as mps', 'mapping_registration_program_study.mapping_path_study_program_id', '=', 'mps.id')
            ->leftjoin('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->leftjoin('study_program_specializations as sps', 'mapping_registration_program_study.study_program_specialization_id', '=', 'sps.id')
            ->where('mapping_registration_program_study.registration_number', '=', $request->registration_number)
            ->orderBy('priority', 'asc')
            ->get();

        //participant biodata
        $participantdata = Registration::GetRegistrationParticipant($request->registration_number, null);

        //participant session
        $session = $this->ViewExamSessionCard($request->registration_number);

        //participant cbt, tpa, wawancara dan psikotes
        $participant_cbt = $this->ViewParticipantMoodleCbt($participantdata['data']);
        $participant_tpa = $this->ViewParticipantTpa($participantdata['data']->selection_path_id);
        $participant_interview = $this->ViewParticipantInterview($participantdata['data']->selection_path_id);
        $participant_psychological = $this->ViewParticipantPsychological($participantdata['data']->selection_path_id);

        //tahun ajaran
        $school_year = Mapping_Path_Year::select()
            ->where('selection_path_id', '=', $participantdata['data']->selection_path_id)
            ->where('active_status', '=', true)
            ->first();

        //validasi ini digunakan untuk menampilkan jadwal psikotes tpa dan wawancara
        //varibale is_medical ini awal nya bernilai false
        //dilakukan pngecheckan pada pilihan program studi mahasiswa
        //jika participant memilih kedokteran maka variable ini berubah menjadi true
        $is_medical = false;

        foreach ($listprodi as $key => $value) {
            if ($value['faculty_id'] == 3 || $value['faculty_id'] == 4) {
                $is_medical = true;
            }
        }

        $data = [
            'program_study' => $listprodi,
            'participant' => $participantdata['data'],
            'sessions' => $session,
            'school_year' => ($school_year == null) ? (date("Y") + 1) . ' - ' . (date('Y') + 2) : $school_year->year,
            'qrcode' => 'https://spmb.trisakti.ac.id/landingpage',
            'is_medical' => $is_medical,
            'participant_psychological' => $participant_psychological,
            'participant_interview' => $participant_interview,
            'participant_tpa' => $participant_tpa,
            'participant_cbt' => $participant_cbt
        ];

        try {
            $pdf = PDF::loadView('registration_card', $data)
                ->setPaper('a4', 'potrait');

            $filenames = 'registration_card/' . $request->registration_number . '_registrationcard.pdf';
            $content = $pdf->download()->getOriginalContent();
            Storage::put($filenames, $content);
            $path = env('FTP_URL') . $filenames;

            return response()->json(['urls' => $path], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to generated registration card',
                'error' => $th->getMessage(),
                'urls' => null
            ], 500);
        }
    }

    function ViewParticipantMoodleCbt($participant)
    {
        //validate exam status = 2 if not 2 return null
        if ($participant->exam_status_id != 2) {
            return null;
        }

        $course = Moodle_Categories::select(
            'moodle_categories.id',
            'moodle_categories.name as moodle_category_name',
            'mc.id as moodle_course_id',
            'mc.fullname as moodle_course_name',
            'mc.startdate',
            'mc.enddate'
        )
            ->join('moodle_courses as mc', function ($join) {
                $join->on('moodle_categories.selection_path_id', '=', 'mc.selection_path_id');
            })
            ->where('moodle_categories.selection_path_id', '=', $participant->selection_path_id)
            ->where('mc.path_exam_detail_id', '=', $participant->path_exam_detail_id)
            ->first();

        return $course;
    }

    //fungsi ini dipergunakan untuk mengambil data tpa pada suatu nomor registrasi
    function ViewParticipantTpa($selection_path_id)
    {
        $data = Path_Exam_Detail::select(
            'path_exam_details.id',
            'path_exam_details.exam_start_date',
            'path_exam_details.exam_end_date',
            'path_exam_details.exam_type_id',
            'path_exam_details.selection_path_id'
        )
            ->where('path_exam_details.selection_path_id', '=', $selection_path_id)
            ->where('path_exam_details.active_status', '=', true)
            ->where('path_exam_details.exam_type_id', '=', 4)
            ->first();

        return $data;
    }

    //fungsi ini dipergunakan untuk mengambil data interview pada suatu nomor registrasi
    function ViewParticipantInterview($selection_path_id)
    {
        $data = Path_Exam_Detail::select(
            'path_exam_details.id',
            'path_exam_details.exam_start_date',
            'path_exam_details.exam_end_date',
            'path_exam_details.exam_type_id',
            'path_exam_details.selection_path_id'
        )
            ->where('path_exam_details.selection_path_id', '=', $selection_path_id)
            ->where('path_exam_details.active_status', '=', true)
            ->where('path_exam_details.exam_type_id', '=', 3)
            ->first();

        return $data;
    }

    //fungsi ini dipergunakan untuk mengambil data psikotes pada suatu nomor registrasi
    function ViewParticipantPsychological($selection_path_id)
    {
        $data = Path_Exam_Detail::select(
            'path_exam_details.id',
            'path_exam_details.exam_start_date',
            'path_exam_details.exam_end_date',
            'path_exam_details.exam_type_id',
            'path_exam_details.selection_path_id'
        )
            ->where('path_exam_details.selection_path_id', '=', $selection_path_id)
            ->where('path_exam_details.active_status', '=', true)
            ->where('path_exam_details.exam_type_id', '=', 2)
            ->first();

        return $data;
    }

    function ViewExamSessionCard($registration_number)
    {
        $program_studies = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.registration_number',
            'mapping_registration_program_study.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->join('mapping_session_study_program as msp', 'sp.classification_id', '=', 'msp.classification_id')
            ->where('mapping_registration_program_study.registration_number', '=', $registration_number)
            ->get();


        $s_one = false;
        $s_two = false;
        $s_three = false;

        foreach ($program_studies as $key => $value) {
            if ($value['session_one'] == true) $s_one = true;
            if ($value['session_two'] == true) $s_two = true;
            if ($value['session_three'] == true) $s_three = true;
        }

        $registration = Registration::select('registration_number', 'selection_path_id', 'path_exam_detail_id')
            ->where('registration_number', '=', $registration_number)
            ->first();

        $path_exam_detail = Path_Exam_Detail::select()
            ->where('id', '=', $registration->path_exam_detail_id)
            ->where('active_status', '=', true)
            ->first();

        $exam_group_ids = array();

        if ($s_one) {
            array_push($exam_group_ids, 1);
        }

        if ($s_two) {
            array_push($exam_group_ids, 2);
        }

        if ($s_three) {
            array_push($exam_group_ids, 3);
        }

        $groups = Moodle_Groups::select(
            'moodle_groups.id',
            'moodle_groups.name',
            'moodle_groups.exam_group_id'
        )
            ->join('moodle_courses as mc', 'moodle_groups.moodle_course_id', '=', 'mc.id')
            ->where('mc.selection_path_id', '=', $registration->selection_path_id)
            ->where('mc.path_exam_detail_id', '=', $registration->path_exam_detail_id)
            ->whereIn('moodle_groups.exam_group_id', $exam_group_ids)
            ->orderBy('moodle_groups.exam_group_id', 'ASC')
            ->get();

        $result = array();

        if ($s_one) {
            array_push($result, [
                'session' => 1,
                'session_name' => (isset($groups[0]) == null) ? null : $groups[0]->name,
                'session_start' => ($path_exam_detail == null) ? null : $path_exam_detail->session_one_start,
                'session_end' => ($path_exam_detail == null) ? null : $path_exam_detail->session_one_end
            ]);
        }

        if ($s_two) {
            array_push($result, [
                'session' => 2,
                'session_name' => (isset($groups[1]) == null) ? null : $groups[1]->name,
                'session_start' => ($path_exam_detail == null) ? null : $path_exam_detail->session_two_start,
                'session_end' => ($path_exam_detail == null) ? null : $path_exam_detail->session_two_end
            ]);
        }

        if ($s_three) {
            array_push($result, [
                'session' => 3,
                'session_name' => (isset($groups[2]) == null) ? null : $groups[2]->name,
                'session_start' => ($path_exam_detail == null) ? null : $path_exam_detail->session_three_start,
                'session_end' => ($path_exam_detail == null) ? null : $path_exam_detail->session_three_end
            ]);
        }

        return $result;
    }

    public function GetParticipantListExcel(Request $request, $program = null, $selection_path = null, $nationality = null)
    {
        $filename = 'DEV/ADM/Admin/ParticipantList/RegistrationList' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new ParticipantListExcel($request->start_date, $request->end_date, $program, $selection_path, $nationality), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    public function GetParticipantPaymentListExcel(Request $request, $program = null, $selection_path = null, $payment_status = null, $payment_method = null)
    {

        $filename = 'DEV/ADM/Admin/ParticipantList/RegistrationPaymentList' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new ParticipantPaymentListExcel($program, $selection_path, $payment_status, $payment_method), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    public function GetParticipantResultListExcel(Request $request, $program = null, $selection_path = null, $registration_number = null)
    {

        $filename = 'DEV/ADM/Admin/ParticipantList/RegistrationResultList' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new ParticipantResultListExcel($program, $selection_path, $registration_number), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    public function GetActiveQuestionnaire(Request $req)
    {
        $test = DB::raw('1');

        if ($req->type != '') {
            $type = ['type', '=', $req->type];
        } else {
            $type = [$test, '=', 1];
        }
        if ($req->selection_path_id != '') {
            $selection_path_id = ['selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$test, '=', 1];
        }

        $active_status = ['active_status', '=', 't'];
        $data['data'] = Questionare::select('id', 'name', 'description', 'active_status', 'type', 'selection_path_id', DB::raw('case when active_status =' . "'t'" . ' then ' . "'Aktif'" . ' else ' . "'Non Aktif'" . ' end as active_status_name'))
            ->where([$type, $selection_path_id, $active_status])
            ->get();
        return response()->json($data, 200);
    }

    public function GetPickListActiveStatus()
    {
        $data = Picklist::select('id', 'pick_name', 'pick_value', 'pick_label')
            ->where('pick_name', '=', 'active_status')
            ->orderBy('id', 'asc')
            ->get();

        return response($data, 200);
    }

    public function GetStatusQuisioner(Request $req)
    {
        $test = DB::raw('1');

        if ($req->registration_number != '') {
            $registration_number = ['registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$test, '=', 1];
        }

        if ($req->participant_id != '') {
            $participant_id = ['participant_id', '=', $req->participant_id];
        } else {
            $participant_id = [$test, '=', 1];
        }

        if ($req->quistionare_id != '') {
            $quistionare_id = ['qt.id', '=', $req->quistionare_id];
        } else {
            $quistionare_id = [$test, '=', 1];
        }

        // $active_status = ['active_status','=','t'];
        $data = Question_Answer::select('qt.id')
            ->join('questions as q', 'q.id', '=', 'question_answers.question_id')
            ->join('quistionare as qt', 'q.questionare_id', '=', 'qt.id')
            ->where([$registration_number, $participant_id, $quistionare_id])
            ->first();


        if ($data) {
            $status['status'] = '1';
            $status['registration_number'] = $req->registration_number;
            $status['participant_id'] = $req->participant_id;
            $status['quistionare_id'] = $req->quistionare_id;
        } else {
            $status['status'] = '0';
            $status['registration_number'] = $req->registration_number;
            $status['participant_id'] = $req->participant_id;
            $status['quistionare_id'] = $req->quistionare_id;
        }
        return response()->json($status, 200);
    }

    public function GetRegistrationHistory(Request $req)
    {
        $completeness_step = DB::raw('case when rr.registration_step_id is null then ' . "'Not Yet'" . ' else ' . "'Done'" . ' end as status');

        $sub_registration_history = "(
            SELECT DISTINCT
                rh.created_at,
                rh.ID,
                rh.registration_number,
                rh.registration_step_id,
                selection_path_id 
            FROM
                registration_history AS rh
                JOIN registrations AS r ON ( rh.registration_number = r.registration_number ) 
            WHERE
                rh.registration_number = '$req->registration_number' 
            ) rr";

        $data = Registration_Steps::select(
            'registration_steps.id as registration_step_id',
            'registration_steps.step',
            'registration_steps.description',
            DB::raw("concat($req->registration_number) as registration_number"),
            $completeness_step
        )
            ->leftjoin(DB::raw($sub_registration_history), 'registration_steps.id', '=', 'rr.registration_step_id')
            // ->orderBy('rr.id', 'ASC')
            ->distinct()
            ->orderBy('registration_steps.id', 'asc')
            ->get();

        return response()->json($data, 200);
    }

    public function GetSumRegistration(Request $req)
    {
        $data = Registration::GetSumParticipant($req->selection_path_id, $req->study_program_id);
        return response()->json(['total' => $data], 200);
    }

    public function GetParticipantSelectionPath(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $data = Registration::select(
            'sp.name as selection_path',
            'sp.id as selection_path_id',
            DB::raw("sum(case when registrations.registration_number is not null then 1 else 0 end) as total"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&selection_path_id=', sp.id, '&field=total') as total_url"),
            DB::raw("sum(case when registrations.payment_status_id = 1 then 1 else 0 end) as paid"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&selection_path_id=', sp.id, '&field=paid') as paid_url"),
            DB::raw("sum(case when ps.registration_number is not null then 1 else 0 end) as total_pass"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&selection_path_id=', sp.id, '&field=total_pass') as total_pass_url"),
            DB::raw("sum(case when reg.registration_number is not null then 1 else 0 end) as total_registration"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&selection_path_id=', sp.id, '&field=total_registration') as total_registration_url")
        )
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('selection_paths as sp', 'mpy.selection_path_id', '=', 'sp.id')
            ->leftjoin(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
            ->leftjoin(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->groupBy('sp.name')
            ->groupBy('sp.id')
            ->get();

        return response()->json($data, 200);
    }

    public function GetParticipantStudyProgram(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $data = Mapping_Path_Study_Program::select(
            'sp.classification_id as program_study_id',
            'sp.study_program_branding_name as program_study',
            'sp.faculty_name as faculty',
            DB::raw("sum(msp.quota) as quota")
        )
            ->join('mapping_path_year as mpy', 'msp.selection_path_id', '=', 'mpy.selection_path_id')
            ->join('study_programs as sp', 'msp.program_study_id', '=', 'sp.classification_id')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('mpy.id', '=', $mapping_path_year_id);
                }
            })
            ->where('msp.active_status', '=', true)
            ->whereNotNull('msp.is_technic')
            ->groupBy('sp.study_program_branding_name')
            ->groupBy('sp.faculty_name')
            ->groupBy('sp.classification_id')
            ->get();

        $total = Registration::select(
            'mrps.program_study_id',
            'mrps.priority',
            DB::raw("count(mrps.program_study_id) as total")
        )
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', 'mpy.id')
            ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->whereNotNull('mrps.program_study_id')
            ->whereIn('mrps.priority', array(1, 2, 3, 4, 5))
            ->groupBy('mrps.program_study_id')
            ->groupBy('mrps.priority')
            ->get();

        $result = array();

        foreach ($data as $key => $value) {

            $value['total_registration'] = 0;
            $value['total_registration_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=total_registration";
            $value['priority_1'] = 0;
            $value['priority_1_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=priority_1";
            $value['priority_2'] = 0;
            $value['priority_2_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=priority_2";
            $value['priority_3'] = 0;
            $value['priority_3_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=priority_3";
            $value['priority_4'] = 0;
            $value['priority_4_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=priority_4";
            $value['priority_5'] = 0;
            $value['priority_5_url'] = "?mapping_path_year=$detail_mapping_path_year_id&program_study_id=" . $value['program_study_id'] . "&field=priority_5";

            foreach ($total as $pr => $v) {
                if ($v['program_study_id'] == $value['program_study_id']) {

                    if ($v['priority'] == 1) {
                        $value['priority_1'] = $value['priority_1'] + $v['total'];
                    } else if ($v['priority'] == 2) {
                        $value['priority_2'] = $value['priority_2'] + $v['total'];
                    } else if ($v['priority'] == 3) {
                        $value['priority_3'] = $value['priority_3'] + $v['total'];
                    } else if ($v['priority'] == 4) {
                        $value['priority_4'] = $value['priority_4'] + $v['total'];
                    } else {
                        $value['priority_5'] = $value['priority_5'] + $v['total'];
                    }

                    $value['total_registration'] = $value['total_registration'] + $v['total'];
                }
            }

            array_push($result, $value);
        }

        return response()->json($result, 200);
    }

    public function GetParticipantGender()
    {
        $result = array();
        $female = Registration::GetSumParticipantGender(2);
        $male = Registration::GetSumParticipantGender(1);

        $result['labels'] = [0 => 'female', 1 => 'male'];
        $result['series'] = [0 => $female, 1 => $male];
        $result['colors'] = [0 => '#F98C8C', 1 => '#E54D4D'];
        return $result;
    }

    public function GetParticipantProvince(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $address_province = '(select id, address_province from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_province from masterdata.public.provinces') AS t1 ( id integer, address_province varchar )) as ap";

        $data = Registration::select(
            DB::raw("sum(case when registrations.payment_status_id = 1 then 1 else 0 end) as paid"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&province_id=', p.address_province, '&field=paid') as paid_url"),
            DB::raw("sum(case when registrations.registration_number is not null then 1 else 0 end) as total"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&province_id=', p.address_province, '&field=total') as total_url"),
            DB::raw("sum(case when ps.registration_number is not null then 1 else 0 end) as total_pass"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&province_id=', p.address_province, '&field=total_pass') as total_pass_url"),
            DB::raw("sum(case when reg.registration_number is not null then 1 else 0 end) as total_registration"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&province_id=', p.address_province, '&field=total_registration') as total_registration_url"),
            'p.address_province',
            'ap.address_province as province'
        )
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->join(DB::raw($address_province), 'p.address_province', '=', 'ap.id')
            ->leftjoin(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
            ->leftjoin(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->groupBy('p.address_province')
            ->groupBy('ap.address_province')
            ->whereNotNull('p.address_province')
            ->get();

        return response()->json($data, 200);
    }

    public function GetParticipantProvinceBackup()
    {
        $data = Registration::GetSumParticipantProvince();
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function GetCountParticipantPaymentPIN(Request $req)
    {
        $data = DB::select("
    select
        name,
         sum(COALESCE(\"2223\", 0)) AS \"2223\",
         sum(COALESCE(\"2122\", 0)) AS \"2122\",
         sum(COALESCE(\"2021\", 0)) AS \"2021\",
         sum(COALESCE(\"1920\", 0)) AS \"1920\",
          sum(COALESCE(\"1819\", 0)) AS \"1819\"
      from
      crosstab(
      '
      SELECT name,school_year,sum(total_participant) total_participant FROM (
        SELECT
        a.name,
        c.school_year,
        count(b.registration_number) total_participant
        FROM 
        selection_paths a
        JOIN registrations b on (a.id=b.selection_path_id)
        join mapping_path_year_intake c on (b.mapping_path_year_intake_id=c.id)
        GROUP BY a.name,c.school_year) a
        GROUP BY name,school_year 
        ORDER BY school_year DESC
        ',$" . '$VALUES' . " ('2223'::text), ('2122'), ('2021'), ('1920'),('1819')$$
        ) as a (\"name\" varchar, \"2223\" numeric , \"2122\" numeric, \"2021\" numeric, \"1920\" numeric,\"1819\" numeric )
                GROUP BY name
        ");

        return response()->json($data, 200);
    }

    //Total Jalur Seleksi yang masih aktif (dilihat dari start date end datenya) dan sudah tidak aktif
    public function GetCountSelectionPath(Request $req)
    {
        $data['aktif'] = Selection_Path::select('id')
            ->where('start_date', '<=', date('Y-m-d') . ' 00:00:00')
            ->where('end_date', '>=', date('Y-m-d') . ' 00:00:00')
            ->count();
        $d = Selection_Path::select('id')
            ->where('start_date', '<=', date('Y-m-d') . ' 00:00:00')
            ->where('end_date', '>=', date('Y-m-d') . ' 00:00:00')
            ->get()
            ->toArray();

        $data['non_aktif'] = Selection_Path::select('id')
            ->whereNotIn('id', $d)
            ->count();


        return response()->json(['data' => $data]);
    }

    //Total Program yang masih aktif
    public function GetCountProgram(Request $req)
    {
        $data['aktif'] = Selection_Path::select('selection_program_id')
            ->where('start_date', '<=', date('Y-m-d') . ' 00:00:00')
            ->where('end_date', '>=', date('Y-m-d') . ' 00:00:00')
            ->distinct()
            ->count();

        $d = Selection_Path::select('selection_program_id')
            ->where('start_date', '<=', date('Y-m-d') . ' 00:00:00')
            ->where('end_date', '>=', date('Y-m-d') . ' 00:00:00')
            ->distinct()
            ->get()
            ->toArray();

        $data['non_aktif'] = Selection_Programs::select('id')
            ->whereNotIn('id', $d)
            ->count();

        return response()->json(['data' => $data, 200]);
    }

    //total pendaftar per registration step
    public function GetParticipantStepCount(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $data = Registration::select(
            DB::raw('COUNT(registrations.registration_number) as total_participant'),
            DB::raw("concat('?mapping_path_year=$detail_mapping_path_year_id', '&step_id=', r.id) as total_participant_url"),
            'r.step',
            'r.id'
        )
            ->leftjoin('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('registration_history as rh', 'registrations.registration_number', '=', 'rh.registration_number')
            ->join('registration_steps as r', 'rh.registration_step_id', '=', 'r.id')
            ->join('selection_paths as s', 'registrations.selection_path_id', '=', 's.id')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->groupBy('r.step', 'r.id')
            ->orderBy('r.id', 'asc')
            ->get();

        return response()->json($data, 200);
    }

    // Laporan Program Studi apa aja yg sedang aktif dibuka, ada berapa program studi, sama listnya
    public function ProgramStudyCountList()
    {
        $data = Mapping_Path_Study_Program::select(
            'msp.selection_path_id',
            'sp.name as selection_path',
            'spp.classification_id as study_program_id',
            'spp.study_program_branding_name as study_program_name',
            'spp.faculty_id',
            'spp.faculty_name',
            'msp.is_technic'
        )
            ->join('study_programs as spp', 'msp.program_study_id', '=', 'spp.classification_id')
            ->join('selection_paths as sp', 'msp.selection_path_id', '=', 'sp.id')
            ->where('msp.active_status', '=', true)
            ->distinct()
            ->get();

        return response()->json([
            'count' => count($data),
            'list' => $data
        ], 200);
    }

    public function GetSelectionCategory()
    {
        $data = Selection_Category::GetSelectionCategory();
        return response()->json($data);
    }

    //get Participant city
    public function GetParticipantCity(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $sub_pass = "(
             select
                 rr.registration_number
             from
                 registration_result as rr
             where
                 rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $address_city = '(select id, address_city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_city from masterdata.public.city_regions') AS t1 ( id integer, address_city varchar )) as ac";

        $data = Registration::select(
            DB::raw("sum(case when registrations.payment_status_id = 1 then 1 else 0 end) as paid"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&city_id=', p.address_city, '&field=paid') as paid_url"),
            DB::raw("sum(case when registrations.registration_number is not null then 1 else 0 end) as total"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&city_id=', p.address_city, '&field=total') as total_url"),
            DB::raw("sum(case when ps.registration_number is not null then 1 else 0 end) as total_pass"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&city_id=', p.address_city, '&field=total_pass') as total_pass_url"),
            DB::raw("sum(case when reg.registration_number is not null then 1 else 0 end) as total_registration"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&city_id=', p.address_city, '&field=total_registration') as total_registration_url"),
            'p.address_city',
            'ac.address_city as city'
        )
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->join(DB::raw($address_city), 'p.address_city', '=', 'ac.id')
            ->leftjoin(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
            ->leftjoin(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->groupBy('p.address_city')
            ->groupBy('ac.address_city')
            ->whereNotNull('p.address_city')
            ->get();

        return response()->json($data, 200);
    }

    //get Participant school
    public function GetParticipantSchool(Request $req)
    {
        //filter
        $mapping_path_year_id = $req->mapping_path_year_id;

        $detail_mapping_path_year_id = ($mapping_path_year_id == null) ? "null" : $mapping_path_year_id;

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $sub_school = "(
            select
                s.id,
                s.name,
                ct.city,
                ct.province
            from
                schools as s
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on
                s.city_region_id::int = ct.id
        ) as s";

        $data = Registration::select(
            's.name as school_name',
            's.city',
            's.province',
            DB::raw("sum(case when registrations.registration_number is not null then 1 else 0 end) as total"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&school_id=', s.id, '&field=total') as total_url"),
            DB::raw("sum(case when registrations.payment_status_id = 1 then 1 else 0 end) as total_paid"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&school_id=', s.id, '&field=total_paid') as total_paid_url"),
            DB::raw("sum(case when ps.registration_number is not null then 1 else 0 end) as total_pass"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&school_id=', s.id, '&field=total_pass') as total_pass_url"),
            DB::raw("sum(case when reg.registration_number is not null then 1 else 0 end) as total_registration"),
            DB::raw("concat('?mapping_path_year_id=$detail_mapping_path_year_id', '&school_id=', s.id, '&field=total_registration') as total_registration_url")
        )
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('participant_educations as pe', 'registrations.participant_id', '=', 'pe.participant_id')
            ->join(DB::raw($sub_school), 'pe.school_id', '=', 's.id')
            ->leftjoin(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
            ->leftjoin(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->groupBy('s.id')
            ->groupBy('s.name')
            ->groupBy('s.city')
            ->groupBy('s.province')
            ->get();

        return response()->json($data, 200);
    }

    //get participant document
    public function GetDocumentParticipantStatus(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['r.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->selection_path_id) {
            $selection_path = ['md.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->required) {
            $required = ['md.required', '=', $req->required];
        } else {
            $required = [$filter, '=', 1];
        }

        $url = env('RECOMMENDATION_URL');
        $query = Mapping_Path_Document::select(
            'r.registration_number',
            'sp.id as selection_path_id',
            'dt.id as document_type_id',
            'dt.name as document_type_name',
            'r.participant_id',
            DB::raw('case 
                when ds.document_id is not null then ds.document_id 
                when dc.document_id is not null then dc.document_id
                when dr.document_id is not null then dr.document_id
                when pd.document_id is not null then pd.document_id
                when dss.document_id is not null then dss.document_id
                when du.document_id is not null then du.document_id
                else null end as document_id
            '),
            DB::raw("case 
                when ds.url is not null then ds.url 
                when dc.url is not null then dc.url
                when dr.url is not null then dr.url
                when pd.url is not null then pd.url
                when dss.url is not null then dss.url
                when du.url is not null then du.url
                else null end as url
            "),
            DB::raw('case when md.required =' . "'t'" . ' then ' . "true" . ' else ' . "false" . ' end as required')
        )
            ->join('selection_paths as sp', 'md.selection_path_id', '=', 'sp.id')
            ->join('document_type as dt', 'md.document_type_id', '=', 'dt.id')
            ->join('registrations as r', 'md.selection_path_id', '=', 'r.selection_path_id')
            ->leftJoin(DB::raw('(
                select 
                document_supporting.id as document_supporting_id, 
                d.id as document_id, 
                dt.id as document_type_id, 
                document_supporting.registration_number, 
                d.url, 
                dt.type 
                from document_supporting 
                inner join documents as d on document_supporting.document_id = d.id 
                inner join document_type as dt on d.document_type_id = dt.id
            ) as ds'), function ($join) {
                $join->on('dt.id', '=', 'ds.document_type_id')
                    ->on('r.registration_number', '=', 'ds.registration_number');
            })
            ->leftJoin(DB::raw('(
                select 
                document_certificate.id as document_certificate, 
                d.id as document_id, 
                dt.id as document_type_id, 
                document_certificate.registration_number, 
                d.url, 
                dt.type 
                from document_certificate 
                inner join documents as d on document_certificate.document_id = d.id 
                inner join document_type as dt on d.document_type_id = dt.id
            ) as dc'), function ($join) {
                $join->on('dt.id', '=', 'dc.document_type_id')
                    ->on('r.registration_number', '=', 'dc.registration_number');
            })
            ->leftJoin(DB::raw('(
                select 
                document_report_card.id as document_report_card_id, 
                d.id as document_id, 
                dt.id as document_type_id, 
                document_report_card.registration_number, 
                d.url, 
                dt.type 
                from document_report_card 
                inner join documents as d on document_report_card.document_id = d.id 
                inner join document_type as dt on d.document_type_id = dt.id
            ) as dr'), function ($join) {
                $join->on('dt.id', '=', 'dr.document_type_id')
                    ->on('r.registration_number', '=', 'dr.registration_number');
            })
            ->leftJoin(DB::raw('(
                select 
                participant_documents.participant_id, 
                participant_documents.id as participant_document_id, 
                d.id as document_id, 
                dt.id as document_type_id, 
                d.url, 
                dt.type 
                from participant_documents 
                inner join documents as d on participant_documents.document_id = d.id 
                inner join document_type as dt on d.document_type_id = dt.id where d.document_type_id is not null
            ) as pd'), function ($join) {
                $join->on('dt.id', '=', 'pd.document_type_id')
                    ->on('r.participant_id', '=', 'pd.participant_id');
            })
            ->leftJoin(DB::raw('(
                select 
                document_study.id, 
                d.id as document_id, 
                dt.id as document_type_id, 
                document_study.registration_number, 
                d.url, 
                dt.type 
                from document_study 
                inner join documents as d on document_study.document_id = d.id 
                inner join document_type as dt on d.document_type_id = dt.id
            ) as dss'), function ($join) {
                $join->on('dt.id', '=', 'dss.document_type_id')
                    ->on('r.registration_number', '=', 'dss.registration_number');
            })
            ->leftJoin(DB::raw('(
                select
                    du.registration_number ,
                    du.id as document_utbk_id,
                    d.id as document_id,
                    dt.id as document_type_id,
                    d.url,
                    dt.type
                from
                    document_utbk as du 
                inner join documents as d on
                    du.document_id = d.id
                inner join document_type as dt on
                    d.document_type_id = dt.id
                where
                    d.document_type_id is not null
            ) as du'), function ($join) {
                $join->on('dt.id', '=', 'du.document_type_id')
                    ->on('r.registration_number', '=', 'du.registration_number');
            })
            ->where([$selection_path, $registration_number, $required])
            ->where('md.active_status', '=', true)
            ->get();

        return response()->json($query, 200);
    }

    //get transaction request
    public function GetPinTransaction(Request $req)
    {
        $result = Transaction_Request::select(
            'id',
            'client_id',
            'trx_amount',
            'customer_name',
            'customer_email',
            'trx_id',
            'virtual_account',
            'registration_number'
        )
            ->where('registration_number', '=', $req->registration_number)
            ->first();

        return response()->json($result, 200);
    }

    //check pin transaction request status
    public function CheckStatusPinTransaction(Request $req)
    {
        $by = $req->header("X-I");

        $transaction_request = Transaction_Request::find($req->id);

        //validate data
        if ($transaction_request == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Transaksi tidak terdaftar dalam sistem.'
            ], 500);
        }

        try {
            //url read transaction va
            $url = env('URL_INQUIRY_TRANSACTION_VA');
            $token = $req->token;

            $http = new Client(['verify' => false]);

            $request = $http->get($url, [
                'query' => [
                    'va_number' => $transaction_request->virtual_account
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            $response = json_decode($request->getBody(), true);

            Transaction_Result::updateOrCreate(
                [
                    'trx_id' => $response['request_body']['trx_id']
                ],
                [
                    'client_id' => $response['request_body']['client_id'],
                    'trx_id' => $response['request_body']['trx_id'],
                    'type' => $response['request_body']['type'],
                    'virtual_account' => $response['response']['virtual_account'],
                    'trx_amount' => $response['response']['trx_amount'],
                    'customer_name' => $response['response']['customer_name'],
                    'customer_email' => $response['response']['customer_email'],
                    'customer_phone' => $response['response']['customer_phone'],
                    'datetime_created' => $response['response']['datetime_created'],
                    'datetime_expired' => $response['response']['datetime_expired'],
                    'datetime_payment' => $response['response']['datetime_payment'],
                    'datetime_last_updated' => $response['response']['datetime_last_updated'],
                    'payment_ntb' => $response['response']['payment_ntb'],
                    'payment_amount' => $response['response']['payment_amount'],
                    'va_status' => $response['response']['va_status'],
                    'description' => $response['response']['description'],
                    'billing_type' => $response['response']['billing_type'],
                    'datetime_created_iso8601' => $response['response']['datetime_created_iso8601'],
                    'datetime_expired_iso8601' => $response['response']['datetime_expired_iso8601'],
                    'datetime_payment_iso8601' => $response['response']['datetime_payment_iso8601'],
                    'datetime_last_updated_iso8601' => $response['response']['datetime_last_updated_iso8601'],
                    'json_response' => json_encode($response),
                    'created_by' => $by,
                    'updated_by' => $by,
                    'registration_number' => $transaction_request->registration_number
                ]
            );

            //validate payment status complete
            if ($response['response']['va_status'] == "2") {
                Registration::where('registration_number', '=', $transaction_request->registration_number)->update([
                    'payment_status_id' => 1,
                    'payment_date' => date('Y-m-d H:i:s', strtotime($response['response']['datetime_payment'])),
                    'activation_pin' => true
                ]);

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Pembayaran Sudah Lunas'
                ]);
            }

            return response()->json([
                'status' => 'Success',
                'message' => 'Pembayaran Belum Lunas'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Transaction Failed',
                'result' => $e->getMessage()
            ], 500);
        }
    }

    //get all soft id
    public function GetSofId(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id != null) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $result = Finpay_Sof_Id::where('active_status', '=', true)
            ->where([$id])
            ->get();

        return response()->json($result, 200);
    }

    public function GenerateExamPassLetter(Request $req)
    {
        $data = Registration_Result::select(
            'registration_result.id',
            'registration_result.registration_number',
            'registration_result.total_score',
            'registration_result.pass_status',
            'registration_result.publication_status',
            'registration_result.publication_date',
            'registration_result.participant_id',
            'registration_result.selection_path_id',
            'registration_result.notes',
            'registration_result.start_date_1',
            'registration_result.start_date_2',
            'registration_result.start_date_3',
            'registration_result.end_date_1',
            'registration_result.end_date_2',
            'registration_result.end_date_3',
            'registration_result.type',
            'registration_result.oldstudentid',
            'registration_result.reference_number',
            'registration_result.password',
            'tb.study_program_id as program_study_id',
            'sp.study_program_branding_name as program_study_name',
            'sp.faculty_id',
            'sp.faculty_name',
            'sp.faculty_name as faculty_name_en',
            'sps.id as specialization_id',
            'sps.specialization_name',
            'sps.class_type_id',
            'sps.class_type',
            DB::raw("case when tb.total_cost is null then 0 else tb.total_cost end as total_cost"),
            'tb.virtual_account',
            'tb.start_date_payment',
            'tb.end_date_payment',
            'p.fullname as name',
            'spt.name as selection_path_name',
            'tb.school_year as schoolyear',
            'registration_result.transfer_status',
            DB::raw("CASE WHEN spt.english_name IS NULL THEN spt.name ELSE spt.english_name END AS selection_path_name_en"),
            DB::raw("CASE WHEN p.gender = 2 THEN 'Ms.' ELSE 'Mr.' END AS pronouns"),
            'tb.json_response as transaction_billing'
        )
            ->join('registrations as r', 'registration_result.registration_number', '=', 'r.registration_number')
            ->join('transaction_billings as tb', 'registration_result.registration_number', '=', 'tb.registration_number')
            ->join('study_programs as sp', 'tb.study_program_id', '=', 'sp.classification_id')
            ->join('study_program_specializations as sps', function ($join) {
                $join->on('tb.specialization_id', '=', 'sps.id')
                    ->on('tb.class_type_id', '=', 'sps.class_type_id');
            })
            ->join('participants as p', 'r.participant_id', '=', 'p.id')
            ->join('selection_paths as spt', 'r.selection_path_id', '=', 'spt.id')
            ->where('registration_result.registration_number', '=', $req->registration_number)
            ->first();

        //convert string json to object
        $data->transaction_billing = json_decode($data->transaction_billing, true);
        // $data->transaction_billing['registration_number'] // how to call json response

        //validate before generating PDF
        if ($data == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to generated exam pass letter',
                'error' => 'Registration_result or Transaction_billing not found',
                'urls' => null
            ], 500);
        }

        try {
            $pdf = PDF::loadView('exam_pass', $data)
                ->setPaper('a4', 'potrait');

            $filenames = 'DEV/ADM/Participant/exam_pass/' . $data->registration_number . '.pdf';
            $content = $pdf->download()->getOriginalContent();
            Storage::put($filenames, $content);

            $path = env('FTP_URL') . $filenames;

            //updated generated at and file url
            Registration_Result::find($data->id)->update([
                'generated_at' => Carbon::now(),
                'file_url' => $path,
                'updated_by' => $req->header("X-I")
            ]);

            return response()->json(['urls' => $path], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Failed to generated exam pass letter',
                'error' => $th->getMessage(),
                'urls' => null
            ], 500);
        }
    }

    //function for showing list voucher
    public function ViewVoucher(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->voucher != null) {
            $voucher = ['voucher', '=', $req->voucher];
        } else {
            $voucher = [$filter, '=', '1'];
        }

        if ($req->type != null) {
            $type = ['type', '=', strtoupper($req->type)];
        } else {
            $type = [$filter, '=', '1'];
        }

        if ($req->active_status != null) {
            $active_status = ['active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        $data = Pin_Voucher::select(
            '*',
            DB::raw("CASE 
                WHEN (active_status = 'f' OR active_status IS NULL) THEN 'Voucher Not Active' 
                WHEN (active_status = 't' AND expire_date >= current_date) THEN 'Voucher Active' 
                WHEN (active_status = 't' AND expire_date < current_date) THEN 'Voucher Expired' 
                END AS Description
            ")
        )
            ->where([$voucher, $type, $active_status])
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    //function for showing used voucher
    public function GetTransactionVoucher(Request $req)
    {
        $data = Transaction_Voucher::select(
            'transaction_voucher.voucher',
            'transaction_voucher.registration_number',
            'p.id as participant_id',
            'p.fullname',
            'r.payment_date',
            'transaction_voucher.created_at',
            'transaction_voucher.updated_at',
            'transaction_voucher.created_by',
            'transaction_voucher.updated_by'
        )
            ->join('registrations as r', 'transaction_voucher.registration_number', '=', 'r.registration_number')
            ->join('participants as p', 'r.participant_id', '=', 'p.id')
            ->where('transaction_voucher.registration_number', '=', $req->registration_number)
            ->first();

        if ($data != null) {
            return response()->json($data, 200);
        } else {
            return response()->json([], 200);
        }
    }

    //fungsi untuk melihat sessi ujian pada participant
    public function ViewExamSession(Request $req)
    {
        $session = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.registration_number',
            'r.selection_path_id',
            'pd.exam_start_date',
            'pd.exam_end_date',
            'pd.session'
        )
            ->join('registrations as r', 'mapping_registration_program_study.registration_number', '=', 'r.registration_number')
            ->join('path_exam_details as pd', 'r.selection_path_id', '=', 'pd.selection_path_id')
            ->where('r.registration_number', '=', $req->registration_number);

        $s_one = Mapping_Registration_Program_Study::select(
            'msp.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('mapping_session_study_program as msp', 'mapping_registration_program_study.program_study_id', '=', 'msp.program_study_id')
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->where('msp.session_one', '=', true)
            ->distinct()
            ->get()
            ->count();

        $s_two = Mapping_Registration_Program_Study::select(
            'msp.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('mapping_session_study_program as msp', 'mapping_registration_program_study.program_study_id', '=', 'msp.program_study_id')
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->where('msp.session_two', '=', true)
            ->distinct()
            ->get()
            ->count();

        $s_three = Mapping_Registration_Program_Study::select(
            'msp.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('mapping_session_study_program as msp', 'mapping_registration_program_study.program_study_id', '=', 'msp.program_study_id')
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->where('msp.session_three', '=', true)
            ->distinct()
            ->get()
            ->count();

        if ($s_three > 0) {
            if ($s_one > 0) {
                /* Ikut Tiga Sessi Ujian, Participant Memilih Desain dan Teknik*/
                $result = $session->where(function ($query) {
                    $query->where('pd.session', '=', '1')
                        ->orWhere('pd.session', '=', '2')
                        ->orWhere('pd.session', '=', '3');
                })
                    ->distinct()
                    ->orderBy('session')
                    ->get();
            } else {
                /* Ikut Dua Sessi Ujian, Participant Memilih Desain*/
                $result = $session->where(function ($query) {
                    $query->Where('pd.session', '=', '2')
                        ->orWhere('pd.session', '=', '3');
                })
                    ->distinct()
                    ->orderBy('session')
                    ->get();
            }
        } else {
            if ($s_one > 0) {
                /* Ikut Dua Sessi Ujian, Participant Memilih Teknik */
                $result = $session->where(function ($query) {
                    $query->where('pd.session', '=', '1')
                        ->orWhere('pd.session', '=', '2');
                })
                    ->distinct()
                    ->orderBy('session')
                    ->get();
            } else {
                /* Ikut Satu Sessi Ujian, Participant Tidak Memilih Desain Atau Teknik */
                $result = $session->where('pd.session', '=', '2')
                    ->distinct()
                    ->orderBy('session')
                    ->get();
            }
        }

        return response()->json($result, 200);
    }

    //function for check participant school isTechnic or not
    public function CheckTechnicMajor(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->participant_id != null) {
            $participatid = ['participant_educations.participant_id', '=', $req->participant_id];
        } else {
            $participatid = [$filter, '=', '1'];
        }

        if ($req->selection_path_id != null) {
            $selection_path = ['sp.id', '=', $req->selection_path_id];
        } else {
            $selection_path = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id == null) {
            return [];
        }

        $pe = Participant_Education::select(
            'participant_educations.id',
            'participant_educations.education_degree_id',
            'ed.level as education_degree',
            'ed.type',
            'participant_educations.education_major_id',
            'em.major as education_major',
            'em.is_technic',
            'participant_educations.graduate_year',
            'participant_educations.student_foreign'
        )
            ->leftJoin('education_majors as em', 'participant_educations.education_major_id', '=', 'em.id')
            ->leftjoin('education_degrees as ed', 'participant_educations.education_degree_id', '=', 'ed.id')
            ->where([$participatid])
            ->orderBy('graduate_year', 'DESC')
            ->first();

        //tmp variable is technic
        $data = 0;

        if ($pe != null) {
            if ($pe->student_foreign == true) {
                //participant berasal dari luar negri
                $data = 1;
            } else {
                //participant bukan berasal dari luar negri

                if ($pe->type == "he" || ($pe->type == "hs" && $pe->is_technic == true)) {
                    //participant bisa memilih semua prodi
                    $data = 1;
                } else {
                    //participant tidak bisa memilih prodi teknik
                    $data = 0;
                }
            }
        } else {
            //participant belum memasukkan data pendidikan
            $data = 0;
        }

        $mappings = Mapping_Path_Study_Program::select(
            'msp.id as mapping_path_program_study_id',
            'sp.id as selection_path_id',
            'sp.name as selection_path',
            DB::raw("CASE WHEN msp.is_technic = 't' THEN true ELSE false END AS is_technic"),
            'msp.quota',
            'msp.minimum_donation',
            't1.study_program_branding_name as study_program_name',
            't1.classification_id as study_program_id',
            't1.faculty_id',
            't1.faculty_name',
            'mpy.id as mapping_path_year_id'
        )
            ->leftjoin('study_programs as t1', 'msp.program_study_id', '=', 't1.classification_id')
            ->leftjoin('selection_paths as sp', 'msp.selection_path_id', '=', 'sp.id')
            ->leftjoin('mapping_path_year as mpy', 'sp.id', '=', 'mpy.selection_path_id')
            ->where('mpy.active_status', '=', true)
            ->where('msp.active_status', '=', true)
            ->where('mpy.id', '=', $req->mapping_path_year_id)
            ->where([$selection_path])
            ->where('mpy.end_date', '>=', Carbon::now());

        if ($data > 0) {
            //paticipant is technic
            $result = $mappings->get();
        } else {
            //paticipant non technic
            $result = $mappings->where(function ($query) {
                $query->where('msp.is_technic', '=', false)
                    ->orWhere('msp.is_technic', '=', null);
            })->get();
        }

        return response()->json($result, 200);
    }

    //function for generate registration via excel
    public function ExportRegistrationExcel(Request $req)
    {
        $filename = 'DEV/ADM/Admin/ParticipantList/MappingRegistrationProgramStudyList' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new MappingRegistrationProgramStudyListExcel($req->selection_path), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    //function for generate
    public function ExportPostGraduateExcel(Request $req)
    {
        $selection_path = null;
        $mapping_path_year_id = null;

        if (isset($_POST['selection_path']))
            $selection_path = $req->selection_path;
        else
            $selection_path = null;

        if (isset($_POST['mapping_path_year_id']))
            $mapping_path_year_id = $req->mapping_path_year_id;
        else
            $mapping_path_year_id = null;

        $filename = 'DEV/ADM/Admin/ParticipantList/ParticipantPostgraduateRegistration' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new PostgraduateRegistration($selection_path, $mapping_path_year_id), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    //function for export participant data registration
    public function ExportParticipantRegistrationExcel(Request $req)
    {
        $selection_path = null;
        $mapping_path_year_id = null;

        if (isset($_POST['selection_path']))
            $selection_path = $req->selection_path;
        else
            $selection_path = null;

        if (isset($_POST['mapping_path_year_id']))
            $mapping_path_year_id = $req->mapping_path_year_id;
        else
            $mapping_path_year_id = null;

        $filename = 'DEV/ADM/Admin/ParticipantList/ParticipantRegistration' . Carbon::now()->toDateString() . '.xlsx';
        Excel::store(new ParticipantRegistrationExcel($selection_path, $mapping_path_year_id), $filename);

        return response()->json(['urls' => env('FTP_URL') . $filename . ''], 200);
    }

    //function for getting last education participant
    public function GetLastParticipantEducation(Request $req)
    {
        $subquerycityprovince = "(
			select city_id, city_detail, province_id, provice_detail from dblink('admission_masterdata', 'select cr.id as city_id, cr.detail_name as city_detail, p.id as province_id, p.detail_name as provice_detail from city_regions as cr inner join provinces as p on cr.province_id = p.id')
			as f (city_id int, city_detail varchar, province_id int, provice_detail varchar)
		) as f";

        $data = Participant_Education::select(
            'participant_educations.participant_id',
            'participant_educations.student_foreign',
            DB::raw("CASE WHEN d.major is null then participant_educations.education_major else d.major end as education_major"),
            DB::raw("CASE WHEN c.name is null then participant_educations.school else c.name end as schools"),
            DB::raw("CASE WHEN c.name is null then '' else c.npsn end as npsn"),
            'f.city_detail as school_city',
            'f.provice_detail as school_provice',
            'participant_educations.graduate_year'
        )
            ->leftJoin('education_degrees as b', 'participant_educations.education_degree_id', '=', 'b.id')
            ->leftJoin('schools as c', 'participant_educations.school_id', '=', 'c.id')
            ->leftJoin('education_majors as d', 'participant_educations.education_major_id', '=', 'd.id')
            ->join(DB::raw("(select max(graduate_year) as graduate_year, participant_id from participant_educations GROUP BY participant_id) as e"), function ($join) {
                $join->on('participant_educations.participant_id', '=', 'e.participant_id')
                    ->on('e.graduate_year', '=', 'participant_educations.graduate_year');
            })
            ->leftJoin(DB::raw($subquerycityprovince), function ($join) {
                $join->on(DB::raw('c.city_region_id::int'), '=', 'f.city_id');
            })
            ->where('participant_educations.participant_id', '=', $req->participant_id)
            ->first();

        return response()->json($data, 200);
    }

    //function for check document report card
    public function RegistrationDocumentReport(Request $req)
    {
        $registration_number = $req->registration_number;
        $subquery = "(select document_report_card.id, document_report_card.gpa, document_report_card.semester_id, document_report_card.range_score, document_report_card.math, document_report_card.physics, document_report_card.bahasa, document_report_card.english, document_report_card.registration_number, document_report_card.created_at, document_report_card.updated_at, document_report_card.created_by, document_report_card.updated_by, document_report_card.document_id, d.url, d.approval_final_status, d.approval_final_date, d.approval_final_by, d.approval_final_comment from document_report_card left join documents as d on document_report_card.document_id = d.id where document_report_card.registration_number = '$registration_number' and document_report_card.semester_id is not null order by document_report_card.semester_id asc) AS document_report_card";

        $filter = DB::raw("1");

        if ($req->semester_id != null) {
            $semester_id = ['semesters.id', '=', $req->semester_id];
        } else {
            $semester_id = [$filter, '=', '1'];
        }

        $data = Semester::select(
            'semesters.id as semester_id',
            'document_report_card.id as document_report_card_id',
            'document_report_card.range_score',
            'document_report_card.math',
            'document_report_card.physics',
            'document_report_card.bahasa',
            'document_report_card.english',
            'document_report_card.registration_number',
            'document_report_card.created_at',
            'document_report_card.updated_at',
            'document_report_card.created_by',
            'document_report_card.updated_by',
            'document_report_card.document_id',
            'document_report_card.url',
            'document_report_card.approval_final_status',
            'document_report_card.approval_final_date',
            'document_report_card.approval_final_by',
            'document_report_card.approval_final_comment',
            'document_report_card.gpa',
            DB::raw("CASE WHEN document_report_card.id IS NOT NULL then true ELSE false END AS status")
        )
            ->leftJoin(DB::raw($subquery), function ($join) {
                $join->on('document_report_card.semester_id', '=', 'semesters.id');
            })
            ->orderBy('semesters.name')
            ->where([$semester_id])
            ->get();

        return response()->json($data, 200);
    }

    //function for view participant list with pagination
    public function ViewParticipantPaginationList(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->program) {
            $program = ['sp.selection_program_id', '=', $req->program];
        } else {
            $program = [$filter, '=', 1];
        }

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->nationality) {
            $nationality = ['p.nationality', '=', $req->nationality];
        } else {
            $nationality = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->payment_status_id) {
            $payment_status_id = ['ps.id', '=', $req->payment_status_id];
        } else {
            $payment_status_id = [$filter, '=', '1'];
        }

        $regist_history = DB::raw('(select max(registration_step_id) as registration_step_id, registration_number from registration_history group by registration_number) as rh');
        $pass_status = DB::raw('case when rr.pass_status = ' . "'f'" . ' then ' . "'Tidak Lulus'" . ' when rr.pass_status = ' . "'t'" . ' then ' . "'Lulus'" . ' else ' . "'Belum Ditentukan'" . ' end as pass_status_name');

        $last_education = "(
            select 
            a.participant_id,
            case when d.major is null then a.education_major else d.major end as education_major,
            case when c.name is null then a.school else c.name end as schools,
            case when c.name is null then '' else c.npsn end as npsn,
            a.graduate_year
        from participant_educations as a
        left join education_degrees as b on (a.education_degree_id = b.id)
        left join schools as c on (a.school_id = c.id)
        left join education_majors as d on (a.education_major_id = d.id)
        join (
            select max(graduate_year) as graduate_year, participant_id from participant_educations GROUP BY participant_id 
        ) as e on (a.participant_id = e.participant_id and e.graduate_year = a.graduate_year)) as d";

        $data = Registration::select(
            'registrations.registration_number',
            'rs.step as registration_step',
            'sp.name as selection_path_name',
            'sp.id as selection_path_id',
            'ps.id as payment_status_id',
            'ps.status as payment_status',
            $pass_status,
            'p.id as participant_id',
            'rr.pass_status',
            'rr.transfer_status',
            'rr.transfer_program_study_id',
            'p.fullname',
            'p.username as email',
            'p.mobile_phone_number',
            'registrations.mapping_path_year_id',
            'd.education_major',
            'd.schools',
            'd.npsn',
            'd.graduate_year'
        )
            ->leftjoin(
                DB::raw($regist_history),
                function ($join) {
                    $join->on('rh.registration_number', '=', 'registrations.registration_number');
                }
            )
            ->leftjoin('registration_steps as rs', 'rh.registration_step_id', '=', 'rs.id')
            ->leftjoin('payment_status as ps', 'registrations.payment_status_id', '=', 'ps.id')
            ->leftjoin('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('registration_result as rr', 'registrations.registration_number', '=', 'rr.registration_number')
            ->leftjoin('mapping_path_year as mpy', 'registrations.mapping_path_year_id', 'mpy.id')
            ->leftjoin(DB::raw($last_education), 'p.id', '=', 'd.participant_id')
            ->where([$program, $selection_path, $nationality, $registration_number, $mapping_path_year_id, $payment_status_id])
            ->orderBy('registrations.registration_number')
            ->distinct()
            ->paginate(20)
            ->setPath(env('URL_ACCESS') . '/eec1e1868149149a1889a19ed56f0dc5');

        return $data;
    }

    //function for view mapping path year
    public function ViewMappingPathYear(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id != null) {
            $id = ['mapping_path_year.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id != null) {
            $selection_path_id = ['mapping_path_year.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        if ($req->year != null) {
            $year = ['mapping_path_year.year', '=', $req->year];
        } else {
            $year = [$filter, '=', '1'];
        }

        if ($req->school_year != null) {
            $school_year = ['mapping_path_year.school_year', '=', $req->school_year];
        } else {
            $school_year = [$filter, '=', '1'];
        }

        if ($req->active_status != null) {
            $active_status = ['mapping_path_year.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        $data = Mapping_Path_Year::select(
            'mapping_path_year.id',
            'mapping_path_year.year',
            'mapping_path_year.school_year',
            'mapping_path_year.active_status',
            'mapping_path_year.selection_path_id',
            'mapping_path_year.start_date',
            'mapping_path_year.end_date',
            'sp.name',
            'sp.english_name',
            'sp.exam_status'
        )
            ->leftjoin('selection_paths as sp', 'mapping_path_year.selection_path_id', '=', 'sp.id')
            ->where([$id, $selection_path_id, $year, $school_year, $active_status])
            ->orderBy('mapping_path_year.school_year', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function ViewParticipantPaymentListPagination(Request $req)
    {
        $filter = DB::raw('1');

        $need_verification = ($req->need_verification == null || $req->need_verification == "null") ? null : $req->need_verification;

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->payment_status) {
            $payment_status = ['registrations.payment_status_id', '=', $req->payment_status];
        } else {
            $payment_status = [$filter, '=', 1];
        }

        if ($req->payment_method) {
            $payment_method = ['registrations.payment_method_id', '=', $req->payment_method];
        } else {
            $payment_method = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        $data = Registration::select(
            'registrations.registration_number',
            'sp.name as selection_path_name',
            'sp.id as selection_path_id',
            'mpp.price',
            'ps.status as payment_status_name',
            'ps.id as payment_status',
            'registrations.payment_url',
            'registrations.payment_approval_date',
            'registrations.payment_approval_by',
            'registrations.payment_url',
            'pm.method as payment_method_name',
            'pm.id as payment_method',
            'registrations.activation_pin',
            'registrations.mapping_path_year_id'
        )
            ->leftjoin('payment_methods as pm', 'pm.id', '=', 'registrations.payment_method_id')
            ->leftjoin('payment_status as ps', 'registrations.payment_status_id', '=', 'ps.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('mapping_path_price as mpp', 'mpp.id', '=', 'registrations.mapping_path_price_id')
            ->leftjoin('mapping_path_year as mpy', 'registrations.mapping_path_year_id', 'mpy.id')
            ->where([$selection_path, $payment_status, $payment_method, $registration_number, $mapping_path_year_id])
            ->where(function ($query) use ($need_verification) {
                if ($need_verification == 1) {
                    //Butuh Verifikasi Pembayaran
                    $query->whereNotNull('registrations.payment_url')
                        ->where('registrations.payment_approval_date', '=', null)
                        ->where('registrations.payment_status_id', '=', 2);
                } else if ($need_verification == 2) {
                    //Lunas
                    $query->where('registrations.payment_status_id', '=', 1);
                } else if ($need_verification == 3) {
                    //Belum Lunas
                    $query->where('registrations.payment_status_id', '=', 2);
                } else if ($need_verification == 4) {
                    //Seluruh Data
                    $query->where(DB::raw('1'), '=', '1');
                } else {
                    //filter tidak digunakan
                    $query->where(DB::raw('1'), '=', '1');
                }
            })
            ->orderBy('registrations.registration_number')
            ->distinct()
            ->paginate(20)
            ->setPath(env('URL_ACCESS') . '/244bfa6bf8885ee2e637860fa6374981');
        return $data;
    }

    public function ListSelectionResultDetailPagination(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->selection_path) {
            $selection_path = ['sp.id', '=', $req->selection_path];
        } else {
            $selection_path = [$filter, '=', 1];
        }

        if ($req->registration_number) {
            $registration_number = ['registrations.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->participant_id) {
            $participant_id = ["registrations.participant_id", "=", $req->participant_id];
        } else {
            $participant_id = [$filter, '=', 1];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        $pass_status =  DB::raw('case when registration_result.pass_status = ' . "'f'" . ' then ' . "'Tidak Lulus'" . ' when registration_result.pass_status = ' . "'t'" . ' then ' . "'Lulus'" . ' else ' . "'Belum Ditentukan'" . ' end as pass_status_name');

        $data = Registration::select(
            'registrations.participant_id',
            'sp.id as selection_path_id',
            'sp.name as selection_path_name',
            'registrations.registration_number',
            'registration_result.total_score',
            $pass_status,
            'registration_result.pass_status',
            'registration_result.publication_status',
            'registration_result.publication_date',
            'registration_result.schoolarship_id',
            'registration_result.spp',
            'registration_result.bpp',
            'registration_result.lainnya',
            'registration_result.ujian',
            'registration_result.praktikum',
            'registration_result.bppdiscount',
            'registration_result.sppdiscount',
            'registration_result.discount',
            'registration_result.semester',
            'registration_result.sks',
            'registration_result.notes',
            'registration_result.start_date_1',
            'registration_result.start_date_2',
            'registration_result.start_date_3',
            'registration_result.end_date_1',
            'registration_result.end_date_2',
            'registration_result.end_date_3',
            'registration_result.schoolyear',
            'registration_result.type',
            'registration_result.oldstudentid',
            'registration_result.reference_number',
            'registration_result.password',
            'registration_result.transfer_status',
            'registration_result.transfer_program_study_id',
            'registration_result.council_date',
            'approval_university',
            'approval_university_by',
            'registration_result.approval_university_at',
            'registration_result.generated_at',
            'registration_result.file_url',
            'registration_result.specialization_id',
            'registration_result.package_id',
            'registration_result.payment_method_id',
            'registration_result.payment_status',
            'tps.study_program_branding_name as transfer_program_study_name',
            'tps.faculty_name as transfer_faculty_name',
            'registration_result.program_study_id as study_program_id',
            'ps.study_program_branding_name as study_program_name',
            'ps.faculty_name as faculty_name',
            'registrations.mapping_path_year_id'
        )
            ->leftjoin('registration_result', 'registration_result.registration_number', '=', 'registrations.registration_number')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('study_programs as ps', 'registration_result.program_study_id', '=', 'ps.classification_id')
            ->leftjoin('study_programs as tps', 'registration_result.transfer_program_study_id', '=', 'tps.classification_id')
            ->where([$selection_path, $registration_number, $participant_id, $mapping_path_year_id])
            ->paginate(20)
            ->setPath(env('URL_ACCESS') . '/a2f9f8b8b19f9cefaf03477df54389ed');

        return $data;
    }

    //function for checkin participant with selection program choose
    public function ValidateParticipantWithSelectionPath(Request $req)
    {
        $data = Registration::select(
            'registrations.registration_number',
            'registrations.payment_status_id',
            'registrations.created_at'
        )
            ->where('registrations.participant_id', '=', $req->participant_id)
            ->where('registrations.selection_path_id', '=', $req->selection_path_id)
            ->where('registrations.mapping_path_year_id', '=', $req->mapping_path_year_id)
            ->where('registrations.mapping_path_year_intake_id', '=', $req->mapping_path_year_intake_id)
            ->get();


        if (count($data) > 0) {
            //check payment status participant
            $last_transaction = array();

            foreach ($data as $key => $value) {
                if ($value['payment_status_id'] == 2) {
                    array_push($last_transaction, $value);
                }
            }

            if (count($last_transaction) > 0) {
                if (Carbon::parse($last_transaction[0]['created_at'])->diffInDays(Carbon::now()) >= 7) {
                    return response()->json([
                        'status' => 'Success',
                        'available' => true,
                        'message' => 'Anda dapat mendaftar di program tersebut'
                    ], 200);
                } else {
                    //pembayaran belum lunas kurang dari 7 hari user tidak bisa create ulang registrasi
                    return response()->json([
                        'status' => 'Failed',
                        'available' => false,
                        'message' => 'Anda sudah pernah mendaftar di program tersebut. Harap selesaikan pembayaran anda'
                    ], 200);
                }
            } else {
                //participant sudah pernah terdaftar diprogram tersebut dan sudah membayarnya
                return response()->json([
                    'status' => 'Failed',
                    'available' => false,
                    'message' => 'Anda sudah pernah mendaftar di program tersebut'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'Success',
                'available' => true,
                'message' => 'Anda dapat mendaftar di program tersebut'
            ], 200);
        }
    }

    //function for showing category in selection program
    public function GetCategorySelectionProgram()
    {
        //constant categories
        $categories = array("INTERNATIONAL", "PJJ-ONLINE", "PASCASARJANA", "REGULER", "EKSTENSI");

        $result = array();
        foreach ($categories as $category) {
            array_push($result, ['category' => $category]);
        }

        return response()->json($result, 200);
    }

    //api for getting 18 / 15 sks
    public function GetStudyProgramSpecialization(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->program_study_id != null) {
            $program_study_id = ['sp.classification_id', '=', $req->program_study_id];
        } else {
            $program_study_id = [$filter, '=', '1'];
        }

        $data = Study_Program_Specialization::select(
            'study_program_specializations.id',
            'study_program_specializations.specialization_name as specialization_name_ori ',
            DB::raw('CONCAT(study_program_specializations.specialization_name,CONCAT(' . "' - '" . ', study_program_specializations.class_type)) AS specialization_name'),
            'study_program_specializations.specialization_code',
            'study_program_specializations.active_status',
            'study_program_specializations.class_type',
            'sp.classification_id as program_study_id',
            'sp.faculty_id',
            'sp.faculty_name',
            'sp.category',
            'sp.classification_name',
            'sp.study_program_branding_name as study_program_name',
            'sp.study_program_name_en',
            'sp.acronim'
        )
            ->join('study_programs as sp', 'study_program_specializations.classification_id', 'sp.classification_id')
            ->where([$program_study_id])
            ->get();

        return response()->json($data, 200);
    }

    //api untuk mengirimkan URL kepada pemberi rekomendasi melalui email)
    public function SendUrlRecomendation(Request $req)
    {
        $document_recomendation = Document_Recomendation::select(
            'document_recomendation.id',
            'document_recomendation.registration_number',
            'document_recomendation.name',
            'document_recomendation.handphone',
            'document_recomendation.email',
            'document_recomendation.token',
            'p.fullname as participant_name'
        )
            ->join('registrations as r', 'document_recomendation.registration_number', '=', 'r.registration_number')
            ->join('participants as p', 'r.participant_id', '=', 'p.id')
            ->where('document_recomendation.id', '=', $req->id)
            ->first();

        if ($document_recomendation == null) {
            return response()->json([
                'status' => 'Failed',
                'success' => false,
                'message' => 'Document recomendation not found'
            ], 500);
        }

        //set link url for body email
        $code = $document_recomendation->token;
        $hash = Hash::make($document_recomendation->id);
        $url_recomendation = env('RECOMMENDATION_URL') . "?code=$code&hash=$hash";

        //message for body email
        $message = "
            Hello $document_recomendation->name<br>
            This email is intended to fill in the recommendation of prospective students with the name <b>$document_recomendation->participant_name</b><br><br>
            Click the link below to directly fill in the recommendations<br>
            <a href='$url_recomendation'>$url_recomendation</a><br><br>
            Please do not reply to this message. <br>
			If you have any questions, please contact us by email (info@smbbtelkom.ac.id).<br><br>
			Thanks and Regards,<br>
			<b>TELKOM UNIVERSITY Admission Team</b><br><br>
        ";

        $param = [
            'to' => $document_recomendation->email,
            'subject' => 'Recomendation Telkom University Admission',
            'content' => $message,
            'toname' => $document_recomendation->name,
            'fromname' => 'Telkom University Admission Team'
        ];

        $http = new \GuzzleHttp\Client;
        $url = 'https://api.telkomuniversity.ac.id/email/send';
        $response = $http->post($url, ['auth' => ['igracias', 'v01DSp!r1T'], 'form_params' => $param]);

        return response([
            'status' => 'Success',
            'success' => true,
            'message' => "Email sent to $document_recomendation->email"
        ], 200);
    }

    //api untuk menampilkan detail recomendation
    public function GetDetailRecomendation(Request $req)
    {
        $document_recomendation = Document_Recomendation::select(
            'document_recomendation.id',
            'document_recomendation.registration_number',
            'document_recomendation.name',
            'document_recomendation.handphone',
            'document_recomendation.email',
            'document_recomendation.position',
            'document_recomendation.institution',
            'document_recomendation.long_capacity_knowing_student',
            'document_recomendation.knowledge',
            'document_recomendation.intellectual',
            'document_recomendation.verbal_expression',
            'document_recomendation.written_expression',
            'document_recomendation.work_independently',
            'document_recomendation.work_cooperate',
            'document_recomendation.maturity',
            'document_recomendation.recomendation',
            'document_recomendation.opinion',
            'document_recomendation.token',
            'p.fullname as participant_name'
        )
            ->leftjoin('documents as d', 'document_recomendation.document_id', '=', 'd.id')
            ->leftjoin('registrations as r', 'r.registration_number', '=', 'document_recomendation.registration_number')
            ->leftjoin('participants as p', 'r.participant_id', '=', 'p.id')
            ->where('document_recomendation.token', '=', $req->code)
            ->first();

        if ($document_recomendation == null) {
            return response()->json([
                'status' => 'Failed',
                'success' => false,
                'message' => 'Token code invalid'
            ], 500);
        }

        if (!Hash::check($document_recomendation->id, $req->hash)) {
            return response()->json([
                'status' => 'Failed',
                'success' => false,
                'message' => 'Hash invalid'
            ], 500);
        }

        return response()->json($document_recomendation, 200);
    }

    //api untuk validasi atau check account dari participant
    public function CheckParticipantAccount(Request $req)
    {
        $data = Participant::select('*')
            ->where(DB::raw("lower(participants.username)"), '=', strtolower($req->email))
            ->get();

        if ($data == null) {
            return response()->json([
                'status' => 'Failed',
                'success' => false,
                'message' => 'Email belum terdaftar didalam aplikasi. Silahkan daftar dengan email tersebut'
            ], 500);
        }

        if (count($data) > 1) {
            return response()->json([
                'status' => 'Failed',
                'success' => false,
                'message' => 'Email sudah terdaftar. Untuk penggunaan akun harap menghubungi Admisi Telkom University situ@smbbtelkom.ac.id'
            ], 500);
        } else {
            return response()->json([
                'status' => 'Success',
                'success' => true,
                'message' => 'Email sudah terdaftar. Siahkan login kedalam aplikasi'
            ], 200);
        }

        return response()->json($data, 200);
    }

    //menampilkan status rekomendasi sudah/belum
    public function GetDocumentRecomendation(Request $req)
    {
        $filter = DB::raw("1");

        if ($req->id != null) {
            $id = ['document_recomendation.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->registration_number != null) {
            $registration_number = ['document_recomendation.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        $data = Document_Recomendation::select(
            'document_recomendation.id',
            'document_recomendation.registration_number',
            'document_recomendation.name',
            'document_recomendation.handphone',
            'document_recomendation.email',
            'document_recomendation.position',
            'document_recomendation.institution',
            'document_recomendation.long_capacity_knowing_student',
            'document_recomendation.knowledge',
            'document_recomendation.intellectual',
            'document_recomendation.verbal_expression',
            'document_recomendation.written_expression',
            'document_recomendation.work_independently',
            'document_recomendation.work_cooperate',
            'document_recomendation.maturity',
            'document_recomendation.recomendation',
            'document_recomendation.opinion',
            'document_recomendation.token',
            'd.id as document_id',
            'd.document_type_id',
            'd.name as document_name',
            'd.description as document_description',
            'd.number as document_number',
            DB::raw("
            CASE WHEN document_recomendation.long_capacity_knowing_student IS NOT NULL AND
            document_recomendation.knowledge IS NOT NULL AND
            document_recomendation.intellectual IS NOT NULL AND
            document_recomendation.verbal_expression IS NOT NULL AND
            document_recomendation.written_expression IS NOT NULL AND
            document_recomendation.work_independently IS NOT NULL AND
            document_recomendation.work_cooperate IS NOT NULL AND
            document_recomendation.recomendation IS NOT NULL AND
            document_recomendation.maturity IS NOT NULL AND
            document_recomendation.opinion IS NOT NULL THEN true ELSE false END AS complete_status
            ")
        )
            ->leftjoin('documents as d', 'document_recomendation.document_id', '=', 'd.id')
            ->where([$id, $registration_number])
            ->get();

        return response()->json($data, 200);
    }

    //api untuk menampilkan detail data peserta yang mengambil program pascasarjana
    public function GetDetailParticipantPostgraduate(Request $req)
    {
        //getting personal data
        $birth_city = '(select id, city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as city from masterdata.public.city_regions') AS t1 ( id integer, city varchar )) as bc";
        $address_city = '(select id, address_city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_city from masterdata.public.city_regions') AS t1 ( id integer, address_city varchar )) as ac";
        $gender = '(select id, gender from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id,gender from masterdata.public.gender') AS t1 ( id integer, gender varchar )) as gender";

        $personal_data = Registration::select(
            'registrations.registration_number',
            'p.id as participant_id',
            'p.fullname',
            'bc.city as birth_city',
            'p.birth_date',
            'gender.gender',
            'p.username as email',
            'p.house_phone_number',
            'p.mobile_phone_number',
            'p.address_detail',
            'ac.address_city',
            'p.address_postal_code',
            'p.photo_url',
            'sp.name as selection_path',
            'sps.name as selection_program',
            'sps.category'
        )
            ->leftjoin('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->leftjoin('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->leftjoin('selection_programs as sps', 'sp.selection_program_id', '=', 'sps.id')
            ->leftjoin(DB::raw($birth_city), function ($join) {
                $join->on('p.birth_city', '=', 'bc.id');
            })
            ->leftjoin(DB::raw($address_city), function ($join) {
                $join->on('p.address_city', '=', 'ac.id');
            })
            ->leftjoin(DB::raw($gender), function ($join) {
                $join->on('p.gender', '=', 'gender.id');
            })
            ->where('registrations.registration_number', '=', $req->registration_number)
            ->where('registrations.participant_id', '=', $req->id)
            ->first();

        //validate personal data
        if ($personal_data == null) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 500);
        }

        //getting participant work data
        $recomendation_data = Document_Recomendation::select(
            'document_recomendation.name',
            'document_recomendation.handphone',
            'document_recomendation.email',
            'document_recomendation.position',
            'document_recomendation.institution',
            'document_recomendation.long_capacity_knowing_student',
            'document_recomendation.knowledge',
            'document_recomendation.intellectual',
            'document_recomendation.verbal_expression',
            'document_recomendation.written_expression',
            'document_recomendation.work_independently',
            'document_recomendation.work_cooperate',
            'document_recomendation.maturity',
            'document_recomendation.recomendation',
            'document_recomendation.opinion',
            DB::raw("
            CASE WHEN document_recomendation.long_capacity_knowing_student IS NOT NULL AND
            document_recomendation.knowledge IS NOT NULL AND
            document_recomendation.intellectual IS NOT NULL AND
            document_recomendation.verbal_expression IS NOT NULL AND
            document_recomendation.written_expression IS NOT NULL AND
            document_recomendation.work_independently IS NOT NULL AND
            document_recomendation.work_cooperate IS NOT NULL AND
            document_recomendation.recomendation IS NOT NULL AND
            document_recomendation.maturity IS NOT NULL AND
            document_recomendation.opinion IS NOT NULL THEN true ELSE false END AS complete_status
            ")
        )
            ->where('document_recomendation.registration_number', '=', $req->registration_number)
            ->get();

        //getting document TPA
        $tpa_data = Document_Study::select(
            'document_study.score',
            'document_study.year',
            'd.url'
        )
            ->leftjoin('documents as d', 'document_study.document_id', '=', 'd.id')
            ->leftjoin('document_type as dt', 'd.document_type_id', '=', 'dt.id')
            ->where('document_study.registration_number', '=', $req->registration_number)
            ->where(DB::raw("lower(dt.name)"), '=', strtolower("TPA"))
            ->first();

        //getting document toefl eprt
        $toefl_data = Document_Study::select(
            'document_study.score',
            'document_study.year',
            'd.url'
        )
            ->leftjoin('documents as d', 'document_study.document_id', '=', 'd.id')
            ->leftjoin('document_type as dt', 'd.document_type_id', '=', 'dt.id')
            ->where('document_study.registration_number', '=', $req->registration_number)
            ->where(DB::raw("lower(dt.name)"), '=', strtolower("EPrT/Toefl"))
            ->first();

        //getting document TPA
        $proposal_data = Document_Study::select(
            'document_study.title',
            'd.url'
        )
            ->leftjoin('documents as d', 'document_study.document_id', '=', 'd.id')
            ->leftjoin('document_type as dt', 'd.document_type_id', '=', 'dt.id')
            ->where('document_study.registration_number', '=', $req->registration_number)
            ->where(DB::raw("lower(dt.name)"), '=', strtolower("Proposal Penelitian"))
            ->first();

        //getting work data
        $work_data = Participant_Work_Data::select(
            'participant_work_data.company_name',
            'participant_work_data.company_address',
            'participant_work_data.company_phone_number',
            'participant_work_data.work_position',
            'wf.field as work_field',
            'wt.name as work_type',
            'wir.range as work_income_range',
            DB::raw("CONCAT(TO_CHAR(participant_work_data.work_start_date, 'DD Mon YYYY')) as work_start_date"),
            DB::raw("CASE WHEN participant_work_data.work_end_date IS NOT NULL THEN CONCAT(TO_CHAR(participant_work_data.work_end_date, 'DD Mon YYYY')) ELSE null END AS work_end_date"),
            DB::raw("CASE WHEN participant_work_data.work_end_date IS NOT NULL THEN 
                CASE WHEN DATE_PART('year', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)) > 0 THEN
                    CASE WHEN DATE_PART('month', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)) > 0 THEN
                        CONCAT(DATE_PART('year', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)), ' Tahun ', DATE_PART('month', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)), ' Bulan')
                    ELSE CONCAT(DATE_PART('year', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)), ' Tahun') END
                ELSE CONCAT(DATE_PART('month', AGE(participant_work_data.work_end_date, participant_work_data.work_start_date)), ' Bulan') END
            ELSE null END AS length_work")
        )
            ->leftjoin('work_fields as wf', 'participant_work_data.work_field_id', '=', 'wf.id')
            ->leftjoin('work_types as wt', 'participant_work_data.work_type_id', '=', 'wt.id')
            ->leftjoin('work_income_range as wir', 'participant_work_data.work_type_id', '=', 'wir.id')
            ->where('participant_work_data.participant_id', '=', $req->id)
            ->orderBy('participant_work_data.work_start_date', 'DESC')
            ->get();

        $specialization_data = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.priority',
            'mapping_registration_program_study.program_study_id',
            'sp.study_program_branding_name as program_study',
            'mapping_registration_program_study.study_program_specialization_id',
            'sps.specialization_name as specialization_name',
            'sps.class_type'
        )
            ->leftjoin('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->leftjoin('study_program_specializations as sps', 'mapping_registration_program_study.study_program_specialization_id', '=', 'sps.id')
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->get();

        $data = [
            'personal_data' => $personal_data,
            'recomendation_data' => $recomendation_data,
            'tpa_data' => $tpa_data,
            'toefl_data' => $toefl_data,
            'work_data' => $work_data,
            'proposal_data' => $proposal_data,
            'specialization_data' => $specialization_data
        ];


        return response()->json($data, 200);
    }

    //api untuk menampilkan list registration card
    public function GetAnnouncementRegistrationCard(Request $req)
    {
        $filter = DB::raw("1");

        if ($req->id) {
            $id = ['announcement_registration_card.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->active_status) {
            $active_status = ['announcement_registration_card.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        $data = Announcement_Registration_Card::select(
            'announcement_registration_card.id',
            'announcement_registration_card.tittle as title',
            'announcement_registration_card.start_date',
            'announcement_registration_card.notes',
            'announcement_registration_card.selection_program_category',
            'announcement_registration_card.active_status',
            'announcement_registration_card.ordering',
            'et.id as exam_type_id',
            'et.name as exam_type'
        )
            ->leftjoin('exam_type as et', 'announcement_registration_card.exam_type', '=', 'et.id')
            ->where([$id, $active_status])
            ->orderBy('announcement_registration_card.ordering', 'ASC')
            ->get();

        return response()->json($data, 200);
    }

    public function GetDocumentUtbk(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['document_utbk.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->registration_number) {
            $registration_number = ['document_utbk.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        $data = Document_Utbk::select(
            'document_utbk.id',
            'document_utbk.document_id',
            'document_utbk.math',
            'document_utbk.physics',
            'document_utbk.chemical',
            'document_utbk.biology',
            'document_utbk.economy',
            'document_utbk.geography',
            'document_utbk.sociological',
            'document_utbk.historical',
            'document_utbk.registration_number',
            'document_utbk.general_reasoning',
            'document_utbk.quantitative_knowledge',
            'document_utbk.comprehension_general_knowledge',
            'document_utbk.comprehension_reading_knowledge',
            'document_utbk.major_type',
            'd.document_type_id',
            'd.url'
        )
            ->join('documents as d', 'document_utbk.document_id', '=', 'd.id')
            ->where([$id, $registration_number])
            ->get();

        return response()->json($data, 200);
    }

    //api for insert mapping report subject path
    public function ViewMappingUtbkPath(Request $req)
    {
        $mpd = Mapping_Path_Document::select(
            'md.id',
            'md.selection_path_id',
            'md.document_type_id',
            'md.required',
            'md.active_status',
            'dt.name as document_type'
        )
            ->leftjoin('document_type as dt', 'md.document_type_id', '=', 'dt.id')
            ->where('md.selection_path_id', '=', $req->selection_path_id)
            ->where('md.document_type_id', '=', $req->document_type_id)
            ->where('md.active_status', '=', $req->active_status)
            ->first();

        $science = Mapping_Utbk_Path::select(
            'mapping_utbk_path.id',
            'mapping_utbk_path.selection_path_id',
            'mapping_utbk_path.is_science',
            'mapping_utbk_path.math',
            'mapping_utbk_path.physics',
            'mapping_utbk_path.biology',
            'mapping_utbk_path.chemical',
            'mapping_utbk_path.economy',
            'mapping_utbk_path.geography',
            'mapping_utbk_path.sociological',
            'mapping_utbk_path.historical',
            'mapping_utbk_path.active_status'
        )
            ->where('mapping_utbk_path.selection_path_id', '=', $req->selection_path_id)
            ->where('mapping_utbk_path.is_science', '=', true)
            ->where('mapping_utbk_path.active_status', '=', $req->active_status)
            ->first();

        $non_science = Mapping_Utbk_Path::select(
            'mapping_utbk_path.id',
            'mapping_utbk_path.selection_path_id',
            'mapping_utbk_path.is_science',
            'mapping_utbk_path.math',
            'mapping_utbk_path.physics',
            'mapping_utbk_path.biology',
            'mapping_utbk_path.chemical',
            'mapping_utbk_path.economy',
            'mapping_utbk_path.geography',
            'mapping_utbk_path.sociological',
            'mapping_utbk_path.historical',
            'mapping_utbk_path.active_status'
        )
            ->where('mapping_utbk_path.selection_path_id', '=', $req->selection_path_id)
            ->where('mapping_utbk_path.is_science', '=', false)
            ->where('mapping_utbk_path.active_status', '=', $req->active_status)
            ->first();

        //response
        $response = $mpd;
        $response['mapping_utbk_path_science'] = $science;
        $response['mapping_utbk_path_non_science'] = $non_science;

        return response()->json($response, 200);
    }

    //api for insert mapping report subject path
    public function ViewMappingReportSubjectPath(Request $req)
    {
        $mpd = Mapping_Path_Document::select(
            'md.id',
            'md.selection_path_id',
            'md.document_type_id',
            'md.required',
            'md.active_status',
            'dt.name as document_type'
        )
            ->leftjoin('document_type as dt', 'md.document_type_id', '=', 'dt.id')
            ->where('md.selection_path_id', '=', $req->selection_path_id)
            ->where('md.document_type_id', '=', $req->document_type_id)
            ->where('md.active_status', '=', $req->active_status)
            ->first();

        $technic = Mapping_Report_Subject_Path::select(
            'mapping_report_subject_path.id',
            'mapping_report_subject_path.selection_path_id',
            'mapping_report_subject_path.is_technic',
            'mapping_report_subject_path.math',
            'mapping_report_subject_path.physics',
            'mapping_report_subject_path.biology',
            'mapping_report_subject_path.chemical',
            'mapping_report_subject_path.bahasa',
            'mapping_report_subject_path.english',
            'mapping_report_subject_path.economy',
            'mapping_report_subject_path.geography',
            'mapping_report_subject_path.sociological',
            'mapping_report_subject_path.historical',
            'mapping_report_subject_path.active_status'
        )
            ->where('mapping_report_subject_path.selection_path_id', '=', $req->selection_path_id)
            ->where('mapping_report_subject_path.is_technic', '=', true)
            ->where('mapping_report_subject_path.active_status', '=', $req->active_status)
            ->first();

        $non_technic = Mapping_Report_Subject_Path::select(
            'mapping_report_subject_path.id',
            'mapping_report_subject_path.selection_path_id',
            'mapping_report_subject_path.is_technic',
            'mapping_report_subject_path.math',
            'mapping_report_subject_path.physics',
            'mapping_report_subject_path.biology',
            'mapping_report_subject_path.chemical',
            'mapping_report_subject_path.bahasa',
            'mapping_report_subject_path.english',
            'mapping_report_subject_path.economy',
            'mapping_report_subject_path.geography',
            'mapping_report_subject_path.sociological',
            'mapping_report_subject_path.historical',
            'mapping_report_subject_path.active_status'
        )
            ->where('mapping_report_subject_path.selection_path_id', '=', $req->selection_path_id)
            ->where('mapping_report_subject_path.is_technic', '!=', true)
            ->where('mapping_report_subject_path.active_status', '=', $req->active_status)
            ->first();

        //response
        $response = $mpd;
        $response['mapping_report_subject_path_technic'] = $technic;
        $response['mapping_report_subject_path_non_technic'] = $non_technic;

        return response()->json($response, 200);
    }

    //function for create session in path exam details
    public function ViewPathExamDetailSession(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['path_exam_details.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['path_exam_details.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        if ($req->active_status) {
            $active_status = ['path_exam_details.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        $sub_union = "(
            select
                ped.id,
                ped.selection_path_id,
                ped.session_one_start as session_start,
                ped.session_one_end as session_end,
                concat('1') as type
            from
                path_exam_details as ped
            union all
            select
                ped.id,
                ped.selection_path_id,
                ped.session_two_start as session_start,
                ped.session_two_end as session_end,
                concat('2') as type
            from
                path_exam_details as ped
            union all
            select
                ped.id,
                ped.selection_path_id,
                ped.session_three_start as session_start,
                ped.session_three_end as session_end,
                concat('3') as type
            from
                path_exam_details as ped
            order by
                id,
                type
        ) as grp";

        $data = Path_Exam_Detail::select('grp.*')
            ->leftjoin(DB::raw($sub_union), function ($join) {
                $join->on('path_exam_details.id', '=', 'grp.id')
                    ->on('path_exam_details.selection_path_id', '=', 'grp.selection_path_id');
            })
            ->where([$id, $selection_path_id, $active_status])
            ->get();

        return response()->json($data, 200);
    }

    //api for view mapping path year intake
    public function ViewMappingPathYearIntakeBackup(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['mapping_path_year_intake.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['mapping_path_year_intake.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->semester) {
            $semester = ['mapping_path_year_intake.semester', '=', $req->semester];
        } else {
            $semester = [$filter, '=', '1'];
        }

        if ($req->school_year) {
            $school_year = ['mapping_path_year_intake.school_year', '=', $req->school_year];
        } else {
            $school_year = [$filter, '=', '1'];
        }

        if ($req->active_status) {
            $active_status = ['mapping_path_year_intake.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['mpy.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        $data = Mapping_Path_Year_Intake::select(
            'mapping_path_year_intake.id',
            'mapping_path_year_intake.semester',
            'mapping_path_year_intake.school_year',
            'mapping_path_year_intake.year',
            'mapping_path_year_intake.notes',
            'mapping_path_year_intake.active_status',
            'mapping_path_year_intake.mapping_path_year_id',
            'mpy.year as mapping_path_year_year',
            'mpy.school_year as mapping_path_year_school_year',
            'mpy.start_date',
            'mpy.end_date',
            'mpy.selection_path_id',
            'sp.name as selection_path',
            'sp.english_name',
            'sp.exam_status'
        )
            ->leftjoin('mapping_path_year as mpy', 'mapping_path_year_intake.mapping_path_year_id', '=', 'mpy.id')
            ->leftjoin('selection_paths as sp', 'mpy.selection_path_id', '=', 'sp.id')
            ->where([$id, $mapping_path_year_id, $semester, $school_year, $active_status, $selection_path_id])
            ->orderBy('mapping_path_year_intake.id', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    //api for view mapping path year intake
    public function ViewMappingPathYearIntake(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['mapping_path_year_intake.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['mapping_path_year_intake.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->semester) {
            $semester = ['mapping_path_year_intake.semester', '=', $req->semester];
        } else {
            $semester = [$filter, '=', '1'];
        }

        if ($req->school_year) {
            $school_year = ['mapping_path_year_intake.school_year', '=', $req->school_year];
        } else {
            $school_year = [$filter, '=', '1'];
        }

        if ($req->active_status) {
            $active_status = ['mapping_path_year_intake.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['mpy.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        $data = Mapping_Path_Year_Intake::select(
            'mapping_path_year_intake.id',
            'mapping_path_year_intake.semester',
            DB::raw("concat(case when mapping_path_year_intake.semester = '1' then 'Ganjil' else 'Genap' end, ', ', mapping_path_year_intake.year) as year"),
            'mapping_path_year_intake.school_year',
            'mapping_path_year_intake.notes',
            'mapping_path_year_intake.active_status',
            'mapping_path_year_intake.mapping_path_year_id',
            'mpy.year as mapping_path_year_year',
            'mpy.school_year as mapping_path_year_school_year',
            'mpy.start_date',
            'mpy.end_date',
            'mpy.selection_path_id',
            'sp.name as selection_path',
            'sp.english_name',
            'sp.exam_status'
        )
            ->leftjoin('mapping_path_year as mpy', 'mapping_path_year_intake.mapping_path_year_id', '=', 'mpy.id')
            ->leftjoin('selection_paths as sp', 'mpy.selection_path_id', '=', 'sp.id')
            ->where([$id, $mapping_path_year_id, $semester, $school_year, $active_status, $selection_path_id])
            ->orderBy('mapping_path_year_intake.id', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function ViewReportCardAllSemester(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['document_report_card.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        $data = Document_Report_Card::select(
            'document_report_card.id',
            'document_report_card.semester_id',
            'document_report_card.document_id',
            'document_report_card.range_score',
            'document_report_card.math',
            'document_report_card.physics',
            'document_report_card.bahasa',
            'document_report_card.english',
            'document_report_card.biology',
            'document_report_card.economy',
            'document_report_card.geography',
            'document_report_card.sociological',
            'document_report_card.historical',
            'document_report_card.registration_number',
            'document_report_card.gpa'
        )
            ->leftjoin('documents as d', 'document_report_card.document_id', '=', 'd.id')
            ->where([$registration_number])
            ->get();

        return response()->json($data, 200);
    }

    public function ViewReportSemester(Request $req)
    {
        $registration = Registration::select(
            'registration_number',
            'selection_path_id'
        )
            ->where('registration_number', '=', $req->registration_number)
            ->first();


        $mrps = Mapping_Registration_Program_Study::select(
            'mpps.id',
            'mpps.selection_path_id',
            'mpps.program_study_id',
            'mpps.is_technic'
        )
            ->leftjoin('mapping_path_program_study as mpps', 'mapping_registration_program_study.mapping_path_study_program_id', '=', 'mpps.id')
            ->where('mapping_registration_program_study.registration_number', '=', $registration->registration_number)
            ->get();

        $math = false;
        $physics = false;
        $biology = false;
        $chemical = false;
        $bahasa = false;
        $english = false;
        $economy = false;
        $geography = false;
        $sociological = false;
        $historical = false;

        $subject_paths = Mapping_Report_Subject_Path::select(
            'mapping_report_subject_path.*'
        )
            ->where('mapping_report_subject_path.selection_path_id', '=', $registration->selection_path_id)
            ->where('mapping_report_subject_path.active_status', '=', true)
            ->get();

        //loop subject path nya untuk dapetin semua data ujian
        foreach ($subject_paths as $key_path => $value_path) {

            //loop data pilihan prodi dari participant
            foreach ($mrps as $key_mrps => $value_mrps) {

                //di validasi status is_technic pilihan prodi dari participant dan is_technic subject path
                if ($value_path['is_technic'] == $value_mrps['is_technic']) {

                    if ($value_path['math'] == true)
                        $math = true;

                    if ($value_path['physics'] == true)
                        $physics = true;

                    if ($value_path['biology'] == true)
                        $biology = true;

                    if ($value_path['chemical'] == true)
                        $chemical = true;

                    if ($value_path['bahasa'] == true)
                        $bahasa = true;

                    if ($value_path['english'] == true)
                        $english = true;

                    if ($value_path['economy'] == true)
                        $economy = true;

                    if ($value_path['geography'] == true)
                        $geography = true;

                    if ($value_path['sociological'] == true)
                        $sociological = true;

                    if ($value_path['historical'] == true)
                        $historical = true;
                }
            }
        }

        $result = array();

        if (isset($req->is_checked) == null) {
            array_push($result, [
                'name' => 'Matematika',
                'key_name' => 'math',
                'is_checked' => $math
            ]);
            array_push($result, [
                'name' => 'Fisika',
                'key_name' => 'physics',
                'is_checked' => $physics
            ]);
            array_push($result, [
                'name' => 'Biologi',
                'key_name' => 'biology',
                'is_checked' => $biology
            ]);
            array_push($result, [
                'name' => 'Kimia',
                'key_name' => 'chemical',
                'is_checked' => $chemical
            ]);
            array_push($result, [
                'name' => 'Bahasa Indonesia',
                'key_name' => 'bahasa',
                'is_checked' => $bahasa
            ]);
            array_push($result, [
                'name' => 'Bahasa Inggris',
                'key_name' => 'english',
                'is_checked' => $english
            ]);
            array_push($result, [
                'name' => 'Ekonomi',
                'key_name' => 'economy',
                'is_checked' => $economy
            ]);
            array_push($result, [
                'name' => 'Geografi',
                'key_name' => 'geography',
                'is_checked' => $geography
            ]);

            array_push($result, [
                'name' => 'Sosiologi',
                'key_name' => 'sociological',
                'is_checked' => $sociological
            ]);

            array_push($result, [
                'name' => 'Sejarah',
                'key_name' => 'historical',
                'is_checked' => $historical
            ]);
        } else {
            if ($req->is_checked == true) {
                if ($math == true) {
                    array_push($result, [
                        'name' => 'Matematika',
                        'key_name' => 'math',
                        'is_checked' => $math
                    ]);
                }

                if ($physics == true) {
                    array_push($result, [
                        'name' => 'Fisika',
                        'key_name' => 'physics',
                        'is_checked' => $physics
                    ]);
                }

                if ($biology == true) {
                    array_push($result, [
                        'name' => 'Biologi',
                        'key_name' => 'biology',
                        'is_checked' => $biology
                    ]);
                }

                if ($chemical == true) {
                    array_push($result, [
                        'name' => 'Kimia',
                        'key_name' => 'chemical',
                        'is_checked' => $chemical
                    ]);
                }

                if ($bahasa == true) {
                    array_push($result, [
                        'name' => 'Bahasa Indonesia',
                        'key_name' => 'bahasa',
                        'is_checked' => $bahasa
                    ]);
                }

                if ($english == true) {
                    array_push($result, [
                        'name' => 'Bahasa Inggris',
                        'key_name' => 'english',
                        'is_checked' => $english
                    ]);
                }

                if ($economy == true) {
                    array_push($result, [
                        'name' => 'Ekonomi',
                        'key_name' => 'economy',
                        'is_checked' => $economy
                    ]);
                }

                if ($geography == true) {
                    array_push($result, [
                        'name' => 'Geografi',
                        'key_name' => 'geography',
                        'is_checked' => $geography
                    ]);
                }

                if ($sociological == true) {
                    array_push($result, [
                        'name' => 'Sosiologi',
                        'key_name' => 'sociological',
                        'is_checked' => $sociological
                    ]);
                }

                if ($historical == true) {
                    array_push($result, [
                        'name' => 'Sejarah',
                        'key_name' => 'historical',
                        'is_checked' => $historical
                    ]);
                }
            } else {
                if ($math == false) {
                    array_push($result, [
                        'name' => 'Matematika',
                        'key_name' => 'math',
                        'is_checked' => $math
                    ]);
                }

                if ($physics == false) {
                    array_push($result, [
                        'name' => 'Fisika',
                        'key_name' => 'physics',
                        'is_checked' => $physics
                    ]);
                }

                if ($biology == false) {
                    array_push($result, [
                        'name' => 'Biologi',
                        'key_name' => 'biology',
                        'is_checked' => $biology
                    ]);
                }

                if ($chemical == false) {
                    array_push($result, [
                        'name' => 'Kimia',
                        'key_name' => 'chemical',
                        'is_checked' => $chemical
                    ]);
                }

                if ($bahasa == false) {
                    array_push($result, [
                        'name' => 'Bahasa Indonesia',
                        'key_name' => 'bahasa',
                        'is_checked' => $bahasa
                    ]);
                }

                if ($english == false) {
                    array_push($result, [
                        'name' => 'Bahasa Inggris',
                        'key_name' => 'english',
                        'is_checked' => $english
                    ]);
                }

                if ($economy == false) {
                    array_push($result, [
                        'name' => 'Ekonomi',
                        'key_name' => 'economy',
                        'is_checked' => $economy
                    ]);
                }

                if ($geography == false) {
                    array_push($result, [
                        'name' => 'Geografi',
                        'key_name' => 'geography',
                        'is_checked' => $geography
                    ]);
                }

                if ($sociological == false) {
                    array_push($result, [
                        'name' => 'Sosiologi',
                        'key_name' => 'sociological',
                        'is_checked' => $sociological
                    ]);
                }

                if ($historical == false) {
                    array_push($result, [
                        'name' => 'Sejarah',
                        'key_name' => 'historical',
                        'is_checked' => $historical
                    ]);
                }
            }
        }

        return response()->json($result, 200);
    }

    //api for view passing grade
    public function ViewPassingGrade(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['passing_grades.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->program_study_id) {
            $program_study_id = ['passing_grades.program_study_id', '=', $req->program_study_id];
        } else {
            $program_study_id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['passing_grades.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->active_status) {
            $active_status = ['passing_grades.active_status', '=', $req->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        $data = Passing_Grade::select(
            'passing_grades.id',
            'passing_grades.program_study_id',
            'sp.study_program_branding_name as program_study_name',
            'sp.category',
            'sp.faculty_id',
            'sp.faculty_name',
            'passing_grades.mapping_path_year_id',
            'passing_grades.general_knowledge',
            'passing_grades.math',
            'passing_grades.english',
            'passing_grades.physics',
            'passing_grades.chemical',
            'passing_grades.biology',
            'passing_grades.drawing',
            'passing_grades.photography_knowledge',
            'passing_grades.active_status',
            'passing_grades.min_grade_value',
            'passing_grades.bahasa',
            'passing_grades.economy',
            'passing_grades.geography',
            'passing_grades.sociological',
            'passing_grades.historical',
            'passing_grades.tpa'
        )
            ->where([$id, $program_study_id, $mapping_path_year_id, $active_status])
            ->leftjoin('study_programs as sp', 'passing_grades.program_study_id', '=', 'sp.classification_id')
            ->get();

        return response()->json($data, 200);
    }

    //function for generate average participant report card
    public function GetAverageParticipantRaportCard(Request $req)
    {
        if ($req->registration_number == null)
            return null;

        $datas = Document_Report_Card::select('*')
            ->where('document_report_card.registration_number', '=', $req->registration_number)
            ->orderBy('document_report_card.semester_id')
            ->get();

        //variable ini untuk menentukan jumlah semester yang akan dihitung
        //jika required_total_semester == null makan total perulangan yang akan dihitung itu ada 6 kali
        $total_semester = ($req->required_total_semester == null) ? 6 : $req->required_total_semester;

        $math = 0;
        $physics = 0;
        $biology = 0;
        $chemical = 0;
        $bahasa = 0;
        $english = 0;
        $economy = 0;
        $geography = 0;
        $sociological = 0;
        $historical = 0;

        for ($i = 0; $i < $total_semester; $i++) {
            $data = $datas[$i];

            if ($data != null) {
                $math += $data->math;
                $physics += $data->physics;
                $biology += $data->biology;
                $chemical += $data->chemical;
                $bahasa += $data->bahasa;
                $english += $data->english;
                $economy += $data->economy;
                $geography += $data->geography;
                $sociological += $data->sociological;
                $historical += $data->historical;
            }
        }

        $result = [
            'math' => ($math / $total_semester),
            'physics' => ($physics / $total_semester),
            'biology' => ($biology / $total_semester),
            'bahasa' => ($bahasa / $total_semester),
            'chemical' => ($chemical / $total_semester),
            'english' => ($english / $total_semester),
            'economy' => ($economy / $total_semester),
            'geography' => ($geography / $total_semester),
            'sociological' => ($sociological / $total_semester),
            'historical' => ($historical / $total_semester)
        ];

        return response()->json($result, 200);
    }

    public function ViewParticipantGrade(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['participant_grades.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->registration_number) {
            $registration_number = ['participant_grades.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['r.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['r.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_intake_id) {
            $mapping_path_year_intake_id = ['r.mapping_path_year_intake_id', '=', $req->mapping_path_year_intake_id];
        } else {
            $mapping_path_year_intake_id = [$filter, '=', '1'];
        }

        $data = Participant_Grade::select(
            'participant_grades.id',
            'participant_grades.math',
            'participant_grades.physics',
            'participant_grades.bahasa',
            'participant_grades.english',
            'participant_grades.biology',
            'participant_grades.economy',
            'participant_grades.geography',
            'participant_grades.sociological',
            'participant_grades.historical',
            'participant_grades.chemical',
            'participant_grades.general_knowledge',
            'participant_grades.photography_knowledge',
            'participant_grades.tpa',
            'participant_grades.tpa',
            'participant_grades.registration_number',
            'participant_grades.grade_final',
            'participant_grades.interview_test',
            'participant_grades.psychological_test',
            'participant_grades.drawing_test',
            'r.selection_path_id',
            'r.mapping_path_year_id',
            'r.mapping_path_year_intake_id'
        )
            ->join('registrations as r', 'participant_grades.registration_number', '=', 'r.registration_number')
            ->where([$id, $registration_number, $selection_path_id, $mapping_path_year_id, $mapping_path_year_intake_id])
            ->get();

        return response()->json($data, 200);
    }

    //api untuk detail realtime dashboard
    public function ViewSpecializationName(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->program_study_id) {
            $program_study_id = ['study_program_specializations.classification_id', '=', $req->program_study_id];
        } else {
            $program_study_id = [$filter, '=', '1'];
        }

        $data = Study_Program_Specialization::select(
            'study_program_specializations.classification_id as program_study_id',
            'study_program_specializations.specialization_name'
        )
            ->where([$program_study_id])
            ->where('study_program_specializations.active_status', '=', true)
            ->distinct()
            ->get();

        return response()->json($data, 200);
    }

    public function ViewClassTypeSpecialization(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->program_study_id) {
            $program_study_id = ['study_program_specializations.classification_id', '=', $req->program_study_id];
        } else {
            $program_study_id = [$filter, '=', '1'];
        }

        if ($req->specialization_name) {
            $specialization_name = [DB::raw("lower(trim(study_program_specializations.specialization_name))"), '=', strtolower(trim($req->specialization_name))];
        } else {
            $specialization_name = [$filter, '=', '1'];
        }

        $data = Study_Program_Specialization::select(
            'study_program_specializations.id',
            'class_type'
        )
            ->where([$program_study_id, $specialization_name])
            ->where('study_program_specializations.active_status', '=', true)
            ->distinct()
            ->get();

        return response()->json($data, 200);
    }

    public function OptionClassTypeSpecialization(Request $req)
    {

        $data = Study_Program_Specialization::select(
            'class_type as id',
            'class_type'
        )
        ->where('study_program_specializations.active_status', '=', true)
        ->distinct()
        ->get();

        return response()->json($data, 200);
    }

    public function ViewParticipantGradeComparePassingGrade(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->study_program_id) {
            $study_program_id = ['pg.program_study_id', '=', $req->study_program_id];
        } else {
            $study_program_id = [$filter, '=', '1'];
        }

        $data = Registration::select(
            'p.fullname',
            'registrations.registration_number',
            'registrations.mapping_path_year_intake_id',
            'pgp.id as participant_grade_id',
            'pgp.math',
            'pgp.physics',
            'pgp.bahasa',
            'pgp.english',
            'pgp.biology',
            'pgp.economy',
            'pgp.geography',
            'pgp.sociological',
            'pgp.historical',
            'pgp.chemical',
            'pgp.general_knowledge',
            'pgp.photography_knowledge',
            'pgp.tpa',
            'pgp.interview_test',
            'pgp.psychological_test',
            'pgp.drawing_test',
            'mrps.approval_faculty',
            'mrps.approval_faculty_at',
            'mrps.approval_faculty_by',
            'mrps.rank',
            DB::raw("case when sp.faculty_id = 3 or sp.faculty_id = 4 then true else false end as is_medical"),
            DB::raw("case when sp.faculty_id = 9 then true else false end as is_art"),
            'sp.classification_id',
            'sp.faculty_id',
            'sp.study_program_branding_name'
        )
            ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->join('participant_grades as pgp', 'registrations.registration_number', '=', 'pgp.registration_number')
            ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
            ->join('study_programs as sp', 'mrps.program_study_id', '=', 'sp.classification_id')
            ->join('passing_grades as pg', function ($join) {
                $join->on('registrations.mapping_path_year_id', '=', 'pg.mapping_path_year_id')
                    ->on('mrps.program_study_id', '=', 'pg.program_study_id');
            })
            ->where([$mapping_path_year_id, $study_program_id])
            ->distinct()
            ->get();

        $passing_grade = Passing_Grade::select('*')
            ->where('mapping_path_year_id', '=', $req->mapping_path_year_id)
            ->where('program_study_id', '=', $req->study_program_id)
            ->where('active_status', '=', true)
            ->first();

        //validate passing grade
        if ($passing_grade == null)
            return [];

        $result = array();

        foreach ($data as $key => $value) {
            $math = ($passing_grade->math == 0 || $passing_grade->math == null) ? 0 : ($passing_grade->math / 100) * $value['math'];
            $physics = ($passing_grade->physics == 0 || $passing_grade->physics == null) ? 0 : ($passing_grade->physics / 100) * $value['physics'];
            $bahasa = ($passing_grade->bahasa == 0 || $passing_grade->bahasa == null) ? 0 : ($passing_grade->bahasa / 100) * $value['bahasa'];
            $english = ($passing_grade->english == 0 || $passing_grade->english == null) ? 0 : ($passing_grade->english / 100) * $value['english'];
            $biology = ($passing_grade->biology == 0 || $passing_grade->biology == null) ? 0 : ($passing_grade->biology / 100) * $value['biology'];
            $economy = ($passing_grade->economy == 0 || $passing_grade->economy == null) ? 0 : ($passing_grade->economy / 100) * $value['economy'];
            $geography = ($passing_grade->geography == 0 || $passing_grade->geography == null) ? 0 : ($passing_grade->geography / 100) * $value['geography'];
            $sociological = ($passing_grade->sociological == 0 || $passing_grade->sociological == null) ? 0 : ($passing_grade->sociological / 100) * $value['sociological'];
            $historical = ($passing_grade->historical == 0 || $passing_grade->historical == null) ? 0 : ($passing_grade->historical / 100) * $value['historical'];
            $chemical = ($passing_grade->chemical == 0 || $passing_grade->chemical == null) ? 0 : ($passing_grade->chemical / 100) * $value['chemical'];
            $general_knowledge = ($passing_grade->general_knowledge == 0 || $passing_grade->general_knowledge == null) ? 0 : ($passing_grade->general_knowledge / 100) * $value['general_knowledge'];
            $photography_knowledge = ($passing_grade->photography_knowledge == 0 || $passing_grade->photography_knowledge == null) ? 0 : ($passing_grade->photography_knowledge / 100) * $value['photography_knowledge'];
            $tpa = ($passing_grade->tpa == 0 || $passing_grade->tpa == null) ? 0 : ($passing_grade->tpa / 100) * $value['tpa'];


            $value['grade_final'] =
                $math +
                $physics +
                $bahasa +
                $english +
                $biology +
                $economy +
                $geography +
                $sociological +
                $historical +
                $chemical +
                $general_knowledge +
                $photography_knowledge +
                $tpa;

            $value['pass_status_grade'] = ($value['grade_final'] >= $passing_grade->min_grade_value) ? true : false;

            array_push($result, [
                'fullname' => $value['fullname'],
                'registration_number' => $value['registration_number'],
                'grade_final' => $value['grade_final'],
                'pass_status_grade' => $value['pass_status_grade'],
                'pass_status_grade' => $value['pass_status_grade'],
                'approval_faculty' => $value['approval_faculty'],
                'approval_faculty_at' => $value['approval_faculty_at'],
                'approval_faculty_by' => $value['approval_faculty_by'],
                'rank' => $value['rank'],
                'tpa' => $value['tpa'],
                'interview_test' => $value['interview_test'],
                'psychological_test' => $value['psychological_test'],
                'drawing_test' => $value['drawing_test'],
                'is_medical' => $value['is_medical'],
                'is_art' => $value['is_art'],
                'study_program_id' => $value['classification_id'],
                'faculty_id' => $value['faculty_id'],
                'study_program_name' => $value['study_program_branding_name']
            ]);
        }

        return response()->json($result, 200);
    }

    public function ViewParticipantGradeComparePassingGradeUniversity(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['registrations.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->study_program_id) {
            $study_program_id = ['rr.program_study_id', '=', $req->study_program_id];
        } else {
            $study_program_id = [$filter, '=', '1'];
        }

        if ($req->approval_university) {
            $approval_university = ['rr.approval_university', '=', $req->approval_university];
        } else {
            $approval_university = [$filter, '=', '1'];
        }

        $data = Registration::select(
            'p.fullname',
            'registrations.registration_number',
            'registrations.mapping_path_year_id',
            'registrations.mapping_path_year_intake_id',
            'pgp.grade_final',
            'rr.program_study_id',
            'rr.specialization_id',
            'sp.study_program_branding_name',
            'rr.approval_university',
            'rr.approval_university_at',
            'rr.approval_university_by',
            DB::raw("case when rr.approval_university is null then null else rr.pass_status end as pass_status")
        )
            ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->join('participant_grades as pgp', 'registrations.registration_number', '=', 'pgp.registration_number')
            ->join('registration_result as rr', 'registrations.registration_number', '=', 'rr.registration_number')
            ->join('study_programs as sp', 'rr.program_study_id', '=', 'sp.classification_id')
            ->where([$mapping_path_year_id, $study_program_id, $approval_university])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle categories
    public function ViewCategoriesMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        $data = Moodle_Categories::select(
            'id',
            'name',
            'description',
            'selection_path_id'
        )
            ->where([$id, $selection_path_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle course
    public function ViewCoursesMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        if ($req->path_exam_detail_id) {
            $path_exam_detail_id = ['path_exam_detail_id', '=', $req->path_exam_detail_id];
        } else {
            $path_exam_detail_id = [$filter, '=', '1'];
        }

        $data = Moodle_Courses::select(
            'id',
            'category_id',
            'shortname',
            'fullname',
            'selection_path_id',
            'summary',
            'startdate as startdate_raw',
            'enddate as enddate_raw',
            DB::raw("to_char(to_timestamp(startdate), 'yyyy-mm-dd hh24:mi:ss') as startdate"),
            DB::raw("to_char(to_timestamp(enddate), 'yyyy-mm-dd hh24:mi:ss') as enddate"),
            'image',
            'group_mode',
            'group_mode_force',
            'enable_completion',
            'path_exam_detail_id'
        )
            ->where([$id, $selection_path_id, $path_exam_detail_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle user
    public function ViewUsersMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = Moodle_Users::select(
            'id',
            'username',
            'password',
            'firstname',
            'lastname',
            'email',
            'participant_id',
            'auth',
            'userpicturepath',
            'userpicture'
        )
            ->where([$id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle section
    public function ViewSectionsMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['moodle_sections.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->moodle_course_id) {
            $moodle_course_id = ['moodle_sections.moodle_course_id', '=', $req->moodle_course_id];
        } else {
            $moodle_course_id = [$filter, '=', '1'];
        }

        $data = Moodle_Sections::select(
            'moodle_sections.id',
            'moodle_sections.name',
            'moodle_sections.moodle_course_id',
            'mc.fullname',
            'mc.selection_path_id',
            DB::raw("to_char(to_timestamp(mc.startdate), 'yyyy-mm-dd hh24:mi:ss') as startdate"),
            DB::raw("to_char(to_timestamp(mc.enddate), 'yyyy-mm-dd hh24:mi:ss') as enddate")
        )
            ->join('moodle_courses as mc', 'moodle_sections.moodle_course_id', 'mc.id')
            ->where([$id, $moodle_course_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle group
    public function ViewGroupsMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['moodle_groups.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->moodle_course_id) {
            $moodle_course_id = ['moodle_groups.moodle_course_id', '=', $req->moodle_course_id];
        } else {
            $moodle_course_id = [$filter, '=', '1'];
        }

        $data = Moodle_Groups::select(
            'moodle_groups.id',
            'moodle_groups.name',
            'moodle_groups.description',
            DB::raw("to_char(to_timestamp(moodle_groups.starttime), 'yyyy-mm-dd hh24:mi:ss') as starttime"),
            'moodle_groups.moodle_course_id',
            'mc.fullname'
        )
            ->join('moodle_courses as mc', 'moodle_groups.moodle_course_id', '=', 'mc.id')
            ->where([$id, $moodle_course_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle member
    public function ViewMembersMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['moodle_members.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->moodle_user_id) {
            $moodle_user_id = ['moodle_members.moodle_user_id', '=', $req->moodle_user_id];
        } else {
            $moodle_user_id = [$filter, '=', '1'];
        }

        if ($req->moodle_group_id) {
            $moodle_group_id = ['moodle_members.moodle_group_id', '=', $req->moodle_group_id];
        } else {
            $moodle_group_id = [$filter, '=', '1'];
        }

        $data = Moodle_Members::select(
            'moodle_members.id',
            'moodle_members.moodle_user_id',
            'mu.email as moodle_user_email',
            'moodle_members.moodle_group_id',
            'mg.name as moodle_group_name'
        )
            ->join('moodle_users as mu', 'moodle_members.moodle_user_id', '=', 'mu.id')
            ->join('moodle_groups as mg', 'moodle_members.moodle_group_id', '=', 'mg.id')
            ->where([$id, $moodle_user_id, $moodle_group_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle enrollment
    public function ViewEnrollmentsMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['moodle_enrollments.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->moodle_user_id) {
            $moodle_user_id = ['moodle_enrollments.moodle_user_id', '=', $req->moodle_user_id];
        } else {
            $moodle_user_id = [$filter, '=', '1'];
        }

        if ($req->moodle_course_id) {
            $moodle_course_id = ['moodle_enrollments.moodle_course_id', '=', $req->moodle_course_id];
        } else {
            $moodle_course_id = [$filter, '=', '1'];
        }

        if ($req->moodle_group_id) {
            $moodle_group_id = ['moodle_enrollments.moodle_group_id', '=', $req->moodle_group_id];
        } else {
            $moodle_group_id = [$filter, '=', '1'];
        }

        $data = Moodle_Enrollments::select(
            'moodle_enrollments.id',
            'moodle_enrollments.role_id',
            DB::raw("to_char(to_timestamp(moodle_enrollments.timestart), 'yyyy-mm-dd hh24:mi:ss') as timestart"),
            DB::raw("to_char(to_timestamp(moodle_enrollments.timeend), 'yyyy-mm-dd hh24:mi:ss') as timeend"),
            'moodle_enrollments.moodle_course_id',
            'mc.fullname as moodle_course_fullname',
            'moodle_enrollments.moodle_user_id',
            'mu.email as moodle_user_email',
            'moodle_enrollments.moodle_group_id',
            'mg.name as moodle_group_name'
        )
            ->join('moodle_courses as mc', 'moodle_enrollments.moodle_course_id', '=', 'mc.id')
            ->join('moodle_users as mu', 'moodle_enrollments.moodle_user_id', '=', 'mu.id')
            ->join('moodle_groups as mg', 'moodle_enrollments.moodle_group_id', '=', 'mg.id')
            ->where([$id, $moodle_course_id, $moodle_user_id, $moodle_group_id])
            ->get();

        return response()->json($data, 200);
    }

    //api for view moodle group
    public function ViewQuizesMoodle(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['moodle_quizes.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->moodle_course_id) {
            $moodle_course_id = ['moodle_quizes.moodle_course_id', '=', $req->moodle_course_id];
        } else {
            $moodle_course_id = [$filter, '=', '1'];
        }

        if ($req->moodle_section_id) {
            $moodle_section_id = ['moodle_quizes.moodle_section_id', '=', $req->moodle_section_id];
        } else {
            $moodle_section_id = [$filter, '=', '1'];
        }

        $data = Moodle_Quizes::select(
            'moodle_quizes.id',
            'moodle_quizes.name',
            'moodle_quizes.description',
            DB::raw("to_char(to_timestamp(moodle_quizes.timeopen), 'yyyy-mm-dd hh24:mi:ss') as timeopen"),
            DB::raw("to_char(to_timestamp(moodle_quizes.timeclose), 'yyyy-mm-dd hh24:mi:ss') as timeclose"),
            'moodle_quizes.timelimit',
            'moodle_quizes.attempts',
            'moodle_quizes.attempt_closed',
            'moodle_quizes.mark_closed',
            'moodle_quizes.moodle_course_id',
            'mc.fullname',
            'moodle_quizes.moodle_section_id',
            'ms.name as section_name'
        )
            ->join('moodle_courses as mc', 'moodle_quizes.moodle_course_id', '=', 'mc.id')
            ->join('moodle_sections as ms', 'moodle_quizes.moodle_section_id', '=', 'ms.id')
            ->where([$id, $moodle_course_id, $moodle_section_id])
            ->get();

        return response()->json($data, 200);
    }

    public function GetDocumentTranscript(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['document_transcript.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->registration_number) {
            $registration_number = ['document_transcript.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        $data = Document_Transcript::select(
            'document_transcript.id',
            'document_transcript.total_credit',
            'document_transcript.total_course',
            'document_transcript.registration_number',
            'document_transcript.document_id',
            'd.url',
            'd.document_type_id'
        )
            ->join('documents as d', 'document_transcript.document_id', '=', 'd.id')
            ->where([$id, $registration_number])
            ->get();

        return response()->json($data, 200);
    }

    public function GetDocumentTranscriptDetail(Request $req)
    {
        $document_transcript = Document_Transcript::select(
            'document_transcript.id',
            'document_transcript.total_credit',
            'document_transcript.total_course',
            'document_transcript.registration_number',
            'document_transcript.document_id',
            'd.url',
            'd.document_type_id'
        )
            ->join('documents as d', 'document_transcript.document_id', '=', 'd.id')
            ->where('document_transcript.id', '=', $req->document_transcript_id)
            ->first();

        if ($document_transcript == null)
            return [];

        $mapping_transcript_participants = Mapping_Transcript_Participant::select(
            'mapping_transcript_participant.id',
            'mapping_transcript_participant.course_code',
            'mapping_transcript_participant.course_name',
            'mapping_transcript_participant.credit_hour',
            'mapping_transcript_participant.grade',
            'mapping_transcript_participant.course_code_approved',
            'mapping_transcript_participant.course_name_approved',
            'mapping_transcript_participant.credit_hour_approved',
            'mapping_transcript_participant.grade_approved',
            'mapping_transcript_participant.approval_by'
        )
            ->where('mapping_transcript_participant.document_transcript_id', '=', $document_transcript->id)
            ->get();

        //result
        $data = $document_transcript;
        $data['courses'] = $mapping_transcript_participants;

        return response()->json($data, 200);
    }

    public function GetParticipantMoodleUser(Request $req)
    {
        $by = $req->header("X-I");
        $user = Framework_User::select('id', 'username', 'email')->where('id', '=', $by)->first();

        //validate if user not found
        if ($user == null) {
            return [
                'email' => null,
                'firstname' => null,
                'lastname' => null,
                'photo_url' => null
            ];
        }

        $participant = Participant::select('username', 'fullname', 'photo_url')
            ->where('username', '=', $user->username)
            ->first();

        //validate if participant not found
        if ($participant == null) {
            return [
                'email' => $user->email,
                'firstname' => Participant::GenerateFirstLastNameFromFullname($user->username)['firstname'],
                'lastname' => Participant::GenerateFirstLastNameFromFullname($user->username)['lastname'],
                'photo_url' => null
            ];
        }

        return [
            'email' => $participant->username,
            'firstname' => Participant::GenerateFirstLastNameFromFullname($participant->fullname)['firstname'],
            'lastname' => Participant::GenerateFirstLastNameFromFullname($participant->fullname)['lastname'],
            'photo_url' => $participant->photo_url
        ];
    }

    public function GetDetailParticipantSchool(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        //validate
        if ($req->school_id == null) {
            return response()->json(['data' => []], 200);
        }

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_school = "(
            select
                s.id,
                s.name,
                s.npsn,
                ct.city,
                ct.province
            from
                schools as s
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on
                s.city_region_id::int = ct.id
        ) as s";

        if ($req->field == "total") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                's.npsn',
                'pe.graduate_year as last_education',
                's.name as school',
                's.city',
                's.province',
                's.id as school_id',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('participant_educations as pe', 'registrations.participant_id', '=', 'pe.participant_id')
                ->join(DB::raw($sub_school), 'pe.school_id', '=', 's.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('s.id', '=', $req->school_id)
                ->get();
        } else if ($req->field == "total_paid") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                's.npsn',
                'pe.graduate_year as last_education',
                's.name as school',
                's.city',
                's.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('participant_educations as pe', 'registrations.participant_id', '=', 'pe.participant_id')
                ->join(DB::raw($sub_school), 'pe.school_id', '=', 's.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('s.id', '=', $req->school_id)
                ->where('registrations.payment_status_id', '=', 1)
                ->get();
        } else if ($req->field == "total_pass") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                's.npsn',
                'pe.graduate_year as last_education',
                's.name as school',
                's.city',
                's.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('participant_educations as pe', 'registrations.participant_id', '=', 'pe.participant_id')
                ->join(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
                ->join(DB::raw($sub_school), 'pe.school_id', '=', 's.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('s.id', '=', $req->school_id)
                ->get();
        } else if ($req->field == "total_registration") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                's.npsn',
                'pe.graduate_year as last_education',
                's.name as school',
                's.city',
                's.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('participant_educations as pe', 'registrations.participant_id', '=', 'pe.participant_id')
                ->join(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
                ->join(DB::raw($sub_school), 'pe.school_id', '=', 's.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('s.id', '=', $req->school_id)
                ->get();
        } else {
            return [];
        }

        return response()->json($data, 200);
    }

    public function GetDetailParticipantProvince(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        $province_id = $req->province_id;

        //validate
        if ($req->province_id == null) {
            return response()->json(['data' => []], 200);
        }

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_last_education = "(
            select
                pe.participant_id,
                string_agg(case when pe.school_id is not null then s.npsn else case when pe.npsn is not null then pe.npsn else pe.npsn_he end end, ',') as npsn,
                string_agg(pe.graduate_year, ',') as last_education,
                string_agg(case when pe.school_id is not null then s.name else pe.school end, ',') as school,
                string_agg(ct.city, ',') as city,
                string_agg(ct.province, ',') as province 
            from
                participant_educations as pe
            left join schools as s on
                pe.school_id = s.id
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on 
                case
                    when pe.school_id is not null then s.city_region_id::int
                    else pe.city_id::int
                end = ct.id
            group by pe.participant_id
        ) as le";

        $address_province = "(select p.id, p.detail_name from provinces as p) as ap";

        if ($req->field == "paid") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_province), 'p.address_province', '=', 'ap.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('registrations.payment_status_id', '=', 1)
                ->where('p.address_province', '=', $province_id)
                ->get();
        } else if ($req->field == "total") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_province), 'p.address_province', '=', 'ap.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_province', '=', $province_id)
                ->get();
        } else if ($req->field == "total_pass") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_province), 'p.address_province', '=', 'ap.id')
                ->join(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_province', '=', $province_id)
                ->get();
        } else if ($req->field == "total_registration") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_province), 'p.address_province', '=', 'ap.id')
                ->join(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_province', '=', $province_id)
                ->get();
        } else {
            return [];
        }

        return response()->json($data, 200);
    }

    public function GetDetailParticipantCity(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        $city_id = $req->city_id;

        //validate
        if ($req->city_id == null) {
            return response()->json(['data' => []], 200);
        }

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_last_education = "(
            select
                pe.participant_id,
                string_agg(case when pe.school_id is not null then s.npsn else case when pe.npsn is not null then pe.npsn else pe.npsn_he end end, ',') as npsn,
                string_agg(pe.graduate_year, ',') as last_education,
                string_agg(case when pe.school_id is not null then s.name else pe.school end, ',') as school,
                string_agg(ct.city, ',') as city,
                string_agg(ct.province, ',') as province 
            from
                participant_educations as pe
            left join schools as s on
                pe.school_id = s.id
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on 
                case
                    when pe.school_id is not null then s.city_region_id::int
                    else pe.city_id::int
                end = ct.id
            group by pe.participant_id
        ) as le";

        //validate
        if ($req->city_id == null) {
            return response()->json(['data' => []], 200);
        }

        $address_city = '(select id, address_city from
                dblink( ' . "'admission_masterdata'" . ',' . "'select id, detail_name as address_city from masterdata.public.city_regions') AS t1 ( id integer, address_city varchar )) as ac";


        if ($req->field == "paid") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_city), 'p.address_city', '=', 'ac.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('registrations.payment_status_id', '=', 1)
                ->where('p.address_city', '=', $city_id)
                ->get();
        } else if ($req->field == "total") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_city), 'p.address_city', '=', 'ac.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_city', '=', $city_id)
                ->get();
        } else if ($req->field == "total_pass") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_city), 'p.address_city', '=', 'ac.id')
                ->join(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_city', '=', $city_id)
                ->get();
        } else if ($req->field == "total_registration") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($address_city), 'p.address_city', '=', 'ac.id')
                ->join(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('p.address_city', '=', $city_id)
                ->get();
        } else {
            return [];
        }

        return response()->json($data, 200);
    }

    //detail total pendaftar per registration step
    public function GetDetailParticipantStepCount(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        if ($req->step_id == "null" || $req->step_id == null) {
            return [];
        }

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_last_education = "(
            select
                pe.participant_id,
                string_agg(case when pe.school_id is not null then s.npsn else case when pe.npsn is not null then pe.npsn else pe.npsn_he end end, ',') as npsn,
                string_agg(pe.graduate_year, ',') as last_education,
                string_agg(case when pe.school_id is not null then s.name else pe.school end, ',') as school,
                string_agg(ct.city, ',') as city,
                string_agg(ct.province, ',') as province 
            from
                participant_educations as pe
            left join schools as s on
                pe.school_id = s.id
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on 
                case
                    when pe.school_id is not null then s.city_region_id::int
                    else pe.city_id::int
                end = ct.id
            group by pe.participant_id
        ) as le";

        $data = Registration::select(
            'p.id as participant_id',
            'registrations.registration_number',
            'p.fullname as name',
            'p.username as email',
            'p.mobile_phone_number',
            'sp.name as selection_path',
            'p1.program_study as prodi_1',
            'le.npsn',
            'le.last_education',
            'le.school',
            'le.city',
            'le.province',
            'prodi_pass.program_study as pass_program_study',
            'registrations.created_at as registration_date',
            'registrations.payment_date',
            'pm.method as payment_methode'
        )
            ->join('registration_history as rh', 'registrations.registration_number', '=', 'rh.registration_number')
            ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
            ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
            ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
            ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
            ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
            ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
            ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
            ->where(function ($query) use ($mapping_path_year_id) {
                if ($mapping_path_year_id == null) {
                    $query->where('mpy.start_date', '<=', Carbon::now())
                        ->where('mpy.end_date', '>=', Carbon::now());
                } else {
                    $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                }
            })
            ->where('rh.registration_step_id', '=', $req->step_id)
            ->get();

        return response()->json($data, 200);
    }

    public function GetDetailParticipantStudyProgram(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        //validate
        if ($req->program_study_id == null || $req->field == null) {
            return [];
        }

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_last_education = "(
            select
                pe.participant_id,
                string_agg(case when pe.school_id is not null then s.npsn else case when pe.npsn is not null then pe.npsn else pe.npsn_he end end, ',') as npsn,
                string_agg(pe.graduate_year, ',') as last_education,
                string_agg(case when pe.school_id is not null then s.name else pe.school end, ',') as school,
                string_agg(ct.city, ',') as city,
                string_agg(ct.province, ',') as province 
            from
                participant_educations as pe
            left join schools as s on
                pe.school_id = s.id
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on 
                case
                    when pe.school_id is not null then s.city_region_id::int
                    else pe.city_id::int
                end = ct.id
            group by pe.participant_id
        ) as le";

        if ($req->field == "total_registration") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->whereIn('mrps.priority', array(1, 2, 3, 4, 5))
                ->get();
        } else if ($req->field == "priority_1") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->where('mrps.priority', '=', 1)
                ->get();
        } else if ($req->field == "priority_2") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->where('mrps.priority', '=', 2)
                ->get();
        } else if ($req->field == "priority_3") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->where('mrps.priority', '=', 3)
                ->get();
        } else if ($req->field == "priority_4") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->where('mrps.priority', '=', 4)
                ->get();
        } else if ($req->field == "priority_5") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join('mapping_registration_program_study as mrps', 'registrations.registration_number', '=', 'mrps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->whereNotNull('mrps.program_study_id')
                ->where('mrps.program_study_id', '=', $req->program_study_id)
                ->where('mrps.priority', '=', 5)
                ->get();
        } else {
            return [];
        }

        return response()->json($data, 200);
    }

    public function GetDetailParticipantSelectionPath(Request $req)
    {
        //filter
        if ($req->mapping_path_year_id == null || $req->mapping_path_year_id == "null") {
            $mapping_path_year_id = null;
        } else {
            $mapping_path_year_id = $req->mapping_path_year_id;
        }

        $selection_path_id = $req->selection_path_id;
        $selection_program_id = $req->selection_program_id;

        $sub_pass = "(
            select
                rr.registration_number
            from
                registration_result as rr
            where
                rr.pass_status = true
        ) ps";

        $sub_registration = "(
            select
                distinct rh.registration_number
            from
                registration_history as rh
            join registrations as r on
                rh.registration_number = r.registration_number
            where rh.registration_step_id = 7
        ) as reg";

        $sub_priority_one = "(
            select
                mrps.registration_number,
                sp.study_program_branding_name as program_study
            from
                mapping_registration_program_study as mrps
            left join study_programs as sp on
                mrps.program_study_id = sp.classification_id 
            where mrps.priority = '1' and mrps.program_study_id is not null
        ) p1";

        $sub_prodi_pass = "(
            select
                rr.registration_number,
                sp.study_program_branding_name as program_study
            from
                registration_result as rr
            left join study_programs as sp on
                rr.program_study_id = sp.classification_id
            where rr.pass_status = true
        ) prodi_pass";

        $sub_last_education = "(
            select
                pe.participant_id,
                string_agg(case when pe.school_id is not null then s.npsn else case when pe.npsn is not null then pe.npsn else pe.npsn_he end end, ',') as npsn,
                string_agg(pe.graduate_year, ',') as last_education,
                string_agg(case when pe.school_id is not null then s.name else pe.school end, ',') as school,
                string_agg(ct.city, ',') as city,
                string_agg(ct.province, ',') as province 
            from
                participant_educations as pe
            left join schools as s on
                pe.school_id = s.id
            left join (
                select
                    id,
                    city,
                    province
                from
                    dblink('admission_masterdata',
                    'select cr.id, cr.detail_name as city, p.detail_name as province from city_regions as cr left join provinces as p on cr.province_id = p.id where p.country_id = 1') as t1 (id integer,
                    city varchar,
                    province varchar)
            ) as ct on 
                case
                    when pe.school_id is not null then s.city_region_id::int
                    else pe.city_id::int
                end = ct.id
            group by pe.participant_id
        ) as le";

        if ($req->field == "total") {
            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->leftjoin(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
                ->leftjoin(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id, $selection_path_id, $selection_program_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now())
                            ->where('mpy.selection_path_id', '=', $selection_path_id);
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->get();
        } else if ($req->field == "paid") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('registrations.payment_status_id', '=', 1)
                ->where('sp.id', '=', $req->selection_path_id)
                ->get();
        } else if ($req->field == "total_pass") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($sub_pass), 'registrations.registration_number', '=', 'ps.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('sp.id', '=', $req->selection_path_id)
                ->get();
        } else if ($req->field == "total_registration") {

            $data = Registration::select(
                'p.id as participant_id',
                'registrations.registration_number',
                'p.fullname as name',
                'p.username as email',
                'p.mobile_phone_number',
                'sp.name as selection_path',
                'p1.program_study as prodi_1',
                'le.npsn',
                'le.last_education',
                'le.school',
                'le.city',
                'le.province',
                'prodi_pass.program_study as pass_program_study',
                'registrations.created_at as registration_date',
                'registrations.payment_date',
                'pm.method as payment_methode'
            )
                ->join('selection_paths as sp', 'registrations.selection_path_id', '=', 'sp.id')
                ->join('mapping_path_year as mpy', 'registrations.mapping_path_year_id', '=', 'mpy.id')
                ->join('participants as p', 'registrations.participant_id', '=', 'p.id')
                ->join('payment_methods as pm', 'registrations.payment_method_id', '=', 'pm.id')
                ->join(DB::raw($sub_registration), 'registrations.registration_number', '=', 'reg.registration_number')
                ->leftjoin(DB::raw($sub_priority_one), 'registrations.registration_number', '=', 'p1.registration_number')
                ->leftjoin(DB::raw($sub_prodi_pass), 'registrations.registration_number', '=', 'prodi_pass.registration_number')
                ->leftjoin(DB::raw($sub_last_education), 'p.id', '=', 'le.participant_id')
                ->where(function ($query) use ($mapping_path_year_id) {
                    if ($mapping_path_year_id == null) {
                        $query->where('mpy.start_date', '<=', Carbon::now())
                            ->where('mpy.end_date', '>=', Carbon::now());
                    } else {
                        $query->where('registrations.mapping_path_year_id', '=', $mapping_path_year_id);
                    }
                })
                ->where('sp.id', '=', $req->selection_path_id)
                ->get();
        } else {
            $data = [];
        }

        return response()->json($data, 200);
    }

    //function for check study program participant with pin
    public function GetStudyProgramWithPin(Request $req)
    {
        $program_studies = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.id',
            'mapping_registration_program_study.priority',
            'mapping_registration_program_study.program_study_id',
            'sp.study_program_branding_name as program_study',
            'sp.faculty_id'
        )
            ->join('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->get();

        //validate program studies participant
        $is_medical = false;
        $study_program_id = null;

        foreach ($program_studies as $key => $value) {
            if ($value['faculty_id'] == 3 || $value['faculty_id'] == 4)
                $is_medical = true;
        }

        if ($is_medical) {
            $filter_is_medical = ['mpp.is_medical', '=', true];
        } else {
            $filter_is_medical = ['mpp.is_medical', '=', false];
        }

        $registration = Registration::select(
            'mapping_registration_program_study.priority',
            'mapping_registration_program_study.program_study_id',
            'registrations.registration_number',
            'registrations.participant_id',
            'mpp.id as mapping_path_price_id',
            // DB::raw("to_char(mpp.price, 'FM999999999') as price"),
            DB::raw('SUM(mpp.price) AS price'), // Replace 'mpp.price' with the actual price column name
            'mpp.maks_study_program'
        )
            // ->leftjoin('mapping_path_price as mpp', 'registrations.selection_path_id', '=', 'mpp.selection_path_id')
            ->join('mapping_registration_program_study', 'mapping_registration_program_study.registration_number', '=', 'registrations.registration_number')
            ->join('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->leftJoin('mapping_path_price AS mpp', function ($join) {
                $join->on('registrations.selection_path_id', '=', 'mpp.selection_path_id');
                // Optional: Add filtering conditions on 'mpp' table if needed
                $join->on('mapping_registration_program_study.program_study_id', '=', 'mpp.study_program_id');
            })
            ->where('registrations.registration_number', '=', $req->registration_number)
            // ->where([$filter_is_medical])
            ->where('mpp.active_status', '=', true)
            ->groupBy('mapping_registration_program_study.priority',
                'mapping_registration_program_study.program_study_id',
                'registrations.registration_number',
                'registrations.participant_id',
                'mpp.id',
                'price',
                'mpp.maks_study_program'
            )
            ->first();

        $result = $registration;
        $result['mapping_registration_program_study'] = $program_studies;

        return response()->json($result, 200);
    }

    public function ViewGroupWithPathExamDetail(Request $req)
    {
        $s_one = false;
        $s_two = false;
        $s_three = false;

        //get program studies
        //and validate with tmp variable session
        $program_studies = Mapping_Registration_Program_Study::select()
            ->where('mapping_registration_program_study.registration_number', '=', $req->registration_number)
            ->leftjoin('mapping_session_study_program as mssp', 'mapping_registration_program_study.program_study_id', '=', 'mssp.classification_id')
            ->get();

        foreach ($program_studies as $key => $value) {
            if ($value['session_one'] == true) {
                $s_one = true;
            }

            if ($value['session_two'] == true) {
                $s_two = true;
            }

            if ($value['session_three'] == true) {
                $s_three = true;
            }
        }

        $exam_group_ids = "";

        if ($s_one && $s_two && $s_three) {
            $exam_group_ids .= "4,";
        } else {
            if ($s_one) {
                $exam_group_ids .= "1,";
            }

            if ($s_two) {
                $exam_group_ids .= "2,";
            }

            if ($s_three) {
                $exam_group_ids .= "3,";
            }
        }

        $exam_group_ids = rtrim($exam_group_ids, ',');

        $sub_group = "(
            select
                string_agg(mg.id::varchar, ',') as moodle_group_ids,
                mg.moodle_course_id 
            from
                moodle_groups as mg
            where
                mg.exam_group_id in($exam_group_ids)
            group by mg.moodle_course_id
        ) mg";

        $data = Moodle_Courses::select(
            'moodle_courses.id',
            'moodle_courses.category_id',
            'moodle_courses.shortname',
            'moodle_courses.fullname',
            'moodle_courses.selection_path_id',
            'moodle_courses.summary',
            DB::raw("to_char(to_timestamp(moodle_courses.startdate), 'yyyy-mm-dd hh24:mi:ss') as startdate"),
            DB::raw("to_char(to_timestamp(moodle_courses.enddate), 'yyyy-mm-dd hh24:mi:ss') as enddate"),
            'moodle_courses.path_exam_detail_id',
            'mg.moodle_group_ids'
        )
            ->where('moodle_courses.selection_path_id', '=', $req->selection_path_id)
            ->join(DB::raw($sub_group), 'moodle_courses.id', '=', 'mg.moodle_course_id')
            ->where(DB::raw("to_timestamp(moodle_courses.startdate)::date"), '>', DB::raw("date_trunc('month', CURRENT_DATE) - INTERVAL '0 months'"))
            ->where(DB::raw("to_timestamp(moodle_courses.startdate)::date"), '<', DB::raw("date_trunc('month', CURRENT_DATE) - INTERVAL '-3 months'"))
            ->get();

        return response()->json($data, 200);
    }

    //function get picklist for verification transaction
    public function GetVerificationTransactionPicklist()
    {
        $data = array();
        array_push($data, [
            'name' => 'Butuh Verifikasi Pembayaran',
            'value' => 1
        ]);

        array_push($data, [
            'name' => 'Lunas',
            'value' => 2
        ]);

        array_push($data, [
            'name' => 'Belum Lunas',
            'value' => 3
        ]);

        array_push($data, [
            'name' => 'Seluruh Data',
            'value' => 4
        ]);

        return response()->json($data, 200);
    }

    //function for view publication type for inserting document publication
    public function GetPublicationType(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = Publication_Type::select('id', 'type')
            ->where([$id])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($data, 200);
    }

    //function for view publication writter position for inserting document publication
    public function GetPublicationWriterPosition(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = Publication_Writer_Position::select('id', 'type')
            ->where([$id])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($data, 200);
    }

    //function to get document publication
    public function GetDocumentPublication(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['document_publication.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->publication_writer_position_id) {
            $publication_writer_position_id = ['document_publication.publication_writer_position_id', '=', $req->publication_writer_position_id];
        } else {
            $publication_writer_position_id = [$filter, '=', '1'];
        }

        if ($req->publication_type_id) {
            $publication_type_id = ['document_publication.publication_type_id', '=', $req->publication_type_id];
        } else {
            $publication_type_id = [$filter, '=', '1'];
        }

        if ($req->participant_id) {
            $participant_id = ['document_publication.participant_id', '=', $req->participant_id];
        } else {
            $participant_id = [$filter, '=', '1'];
        }

        $data = Document_Publication::select(
            'document_publication.id',
            'document_publication.writer_name',
            'document_publication.title',
            'document_publication.publish_date',
            'document_publication.publication_link',
            'document_publication.publication_writer_position_id',
            'pwp.type as publication_writer_position',
            'document_publication.publication_type_id',
            'pt.type as publication_type',
            'document_publication.document_id',
            'd.name as document_name',
            'd.url',
            'd.document_type_id',
            'document_publication.participant_id'
        )
            ->leftjoin('publication_type as pt', 'document_publication.publication_type_id', '=', 'pt.id')
            ->leftjoin('publication_writer_position as pwp', 'document_publication.publication_writer_position_id', '=', 'pwp.id')
            ->leftjoin('documents as d', 'document_publication.document_id', '=', 'd.id')
            ->where([$id, $publication_writer_position_id, $publication_type_id, $participant_id])
            ->get();

        return response()->json($data, 200);
    }

    public function GetNewStudentStep(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        $data = New_Student_Step::select(
            'id',
            'step',
            'description'
        )
            ->where('active_status', '=', true)
            ->where([$id])
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json($data, 200);
    }

    //function for getting new student
    public function GetNewStudent(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['new_student.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->registration_number) {
            $registration_number = ['new_student.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', '1'];
        }

        if ($req->participant_id) {
            $participant_id = ['new_student.participant_id', '=', $req->participant_id];
        } else {
            $participant_id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['r.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_id) {
            $mapping_path_year_id = ['r.mapping_path_year_id', '=', $req->mapping_path_year_id];
        } else {
            $mapping_path_year_id = [$filter, '=', '1'];
        }

        if ($req->mapping_path_year_intake_id) {
            $mapping_path_year_intake_id = ['r.mapping_path_year_intake_id', '=', $req->mapping_path_year_intake_id];
        } else {
            $mapping_path_year_intake_id = [$filter, '=', '1'];
        }

        $sub_step = "(
            select
                new_student_step_id,
                new_student_id
            from
                mapping_new_student_step
            where
                new_student_step_id = 3
            group by
                new_student_step_id,
                new_student_id
        ) as step";

        $data = New_Student::select(
            'new_student.id',
            'new_student.registration_number',
            'new_student.email as university_email',
            'new_student.student_id',
            'new_student.participant_id',
            'p.fullname as account_name',
            'p.username as account_email',
            'new_student.program_study_id',
            'sps.study_program_branding_name',
            'sp.id as selection_path_id',
            'sp.name as selection_path_name',
            'r.mapping_path_year_id',
            'r.mapping_path_year_intake_id',
            DB::raw("case when new_student.email is not null and new_student.student_id is not null then 1 else 0 end as status_registration"),
            DB::raw("case when new_student.email is not null and new_student.student_id is not null then 'Lengkap' else 'Belum Lengkap' end as status_registration_name"),
            DB::raw("case when step.new_student_id is null then 0 else 1 end as completeness_registration"),
            DB::raw("case when step.new_student_id is null then 'Belum Lengkap' else 'Lengkap' end as completeness_registration_name")
        )
            ->join('registrations as r', 'new_student.registration_number', '=', 'r.registration_number')
            ->join('selection_paths as sp', 'r.selection_path_id', '=', 'sp.id')
            ->join('study_programs as sps', 'new_student.program_study_id', '=', 'sps.classification_id')
            ->join('participants as p', 'new_student.participant_id', '=', 'p.id')
            ->leftjoin(DB::raw($sub_step), 'new_student.id', '=', 'step.new_student_id')
            ->where([$id, $registration_number, $participant_id, $selection_path_id, $mapping_path_year_id, $mapping_path_year_intake_id])
            ->orderBy('new_student.created_at', 'DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function GetParticipantData(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->username) {
            $username = [DB::raw("lower(participants.username)"), '=', str_replace('%20', ' ', strtolower($req->username))];
        } else {
            $username = [$filter, '=', 1];
        }

        $data = Participant::select(
            'participants.id as participant_id',
            'participants.fullname',
            'participants.username',
            'participants.username as email',
            'participants.photo_url',
            'participants.identify_number',
            'participants.passport_number',
            'participants.passport_expiry_date',
            'participants.mobile_phone_number'
        )
            ->where([$username])
            ->where('participants.isverification', '=', true)
            ->first();

        return response()->json($data, 200);
    }

    public function GetNewStudentDocumentType(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['new_student_document_type.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->document_type_id) {
            $document_type_id = ['new_student_document_type.document_type_id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', '1'];
        }

        $data = New_Student_Document_Type::select(
            'new_student_document_type.id',
            'new_student_document_type.name',
            'new_student_document_type.document_type_id'
        )
            ->where([$id, $document_type_id])
            ->get();

        return response()->json($data, 200);
    }

    public function ViewMappingNewStudentDocumentPath(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->new_student_document_type_id) {
            $new_student_document_type_id = ['nsdt.id', '=', $req->new_student_document_type_id];
        } else {
            $new_student_document_type_id = [$filter, '=', '1'];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['sp.id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', '1'];
        }

        $data = Mapping_New_Student_Document_Type::select(
            'mapping_new_student_document_path.id',
            'mapping_new_student_document_path.new_student_document_type_id',
            'nsdt.name as new_student_document_type',
            'nsdt.document_type_id',
            'mapping_new_student_document_path.selection_path_id',
            'sp.name as selection_path'
        )
            ->join('new_student_document_type as nsdt', 'mapping_new_student_document_path.new_student_document_type_id', '=', 'nsdt.id')
            ->join('selection_paths as sp', 'mapping_new_student_document_path.selection_path_id', '=', 'sp.id')
            ->where([$new_student_document_type_id, $selection_path_id])
            ->get();

        return response()->json($data, 200);
    }

    public function GetNewStudentParticipantData(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->participant_id) {
            $participant_id = ['participants.id', '=', $req->participant_id];
        } else {
            $participant_id = [$filter, '=', 1];
        }

        if ($req->username) {
            $username = [DB::raw("lower(participants.username)"), '=', str_replace('%20', ' ', strtolower($req->username))];
        } else {
            $username = [$filter, '=', 1];
        }

        $data = Participant::select(
            'participants.fullname',
            'participants.gender',
            'participants.religion',
            'participants.birth_city',
            'participants.birth_province',
            'participants.birth_country',
            'birth_date',
            'participants.nationality',
            'participants.origin_country',
            'participants.identify_number',
            'participants.passport_number',
            'participants.passport_expiry_date',
            'participants.address_country',
            'participants.address_province',
            'participants.address_city',
            'participants.address_disctrict',
            'address_detail',
            'address_postal_code',
            'house_phone_number',
            'mobile_phone_number',
            'participants.id as participant_id',
            'participants.username',
            'participants.photo_url',
            DB::raw("CASE WHEN participants.color_blind IS NULL THEN 'Tidak' ELSE participants.color_blind END AS color_blind"),
            'participants.special_needs',
            'participants.birth_province_foreign',
            'participants.birth_city_foreign',
            'participants.nisn',
            'participants.nis',
            'participants.diploma_number'
        )
            ->where([$username, $participant_id])
            ->where('participants.isverification', '=', true)
            ->first();


        if (isset($data->passport_number)) {
            $data['passport_number'] = $data->passport_number;
        } else {
            $data['passport_number'] = '-';
        }

        if (isset($data->passport_expiry_date)) {
            $data['passport_expiry_date'] = Carbon::parse($data->passport_expiry_date)->format('Y-m-d');
        } else {
            $data['passport_expiry_date'] = '-';
        }

        if (isset($data->gender)) {
            $data['gender_name'] = Gender::getGenderName($data->gender)->gender;
        } else {
            $data['gender_name'] = '';
        }

        if (isset($data->religion)) {
            $data['religion_name'] = Religion::getReligionName($data->religion)->religion;
        } else {
            $data['religion_name'] = '';
        }

        if (isset($data->birth_city)) {
            $data['birth_city_name'] = City_Region::GetCityName($data->birth_city)->city;
        } else {
            if (isset($data->birth_city_foreign)) {
                $data['birth_city_name'] = $data->birth_city_foreign;
            } else {
                $data['birth_city_name'] = '';
            }
        }

        if (isset($data->birth_province)) {
            $data['birth_province_name'] = Province::GetProvinceName($data->birth_province)->detail_name;
        } else {
            if (isset($data->birth_province_foreign)) {
                $data['birth_province_name'] = $data->birth_province_foreign;
            } else {
                $data['birth_province_name'] = '';
            }
        }

        if (isset($data->origin_country)) {
            $data['origin_country_name'] = Country::GetCountryName($data->origin_country)->detail_name;
        } else {
            $data['origin_country_name'] = '';
        }

        if (isset($data->birth_country)) {
            $data['birth_country_name'] = Country::GetCountryName($data->birth_country)->detail_name;
        } else {
            $data['birth_country_name'] = '';
        }

        if (isset($data->nationality)) {
            $data['nationality_name'] = Nationality::getNationalityName($data->nationality)->nationality;
        } else {
            $data['nationality_name'] = '';
        }

        if (isset($data->address_city)) {
            $data['address_city_name'] = City_Region::GetCityName($data->address_city)->city;
        } else {
            $data['address_city_name'] = '';
        }

        if (isset($data->address_province)) {
            $data['address_province_name'] = Province::GetProvinceName($data->address_province)->detail_name;
        } else {
            $data['address_province_name'] = '';
        }

        if (isset($data->address_country)) {
            $data['address_country_name'] = Country::GetCountryName($data->address_country)->detail_name;
        } else {
            $data['address_country_name'] = '';
        }

        if (isset($data->address_disctrict)) {
            $data['address_disctrict_name'] = District::GetDistrictName($data->address_disctrict)->detail_name;
        } else {
            $data['address_disctrict_name'] = '';
        }

        return response()->json($data);
    }

    public function GetNewStudentFamilyParticipantData(Request $req)
    {
        $father = Participant_Family::select('*')
            ->where('family_relationship_id', '=', 1)
            ->where('participant_id', '=', $req->participant_id)
            ->where('active_status', '=', true)
            ->first();

        $mother = Participant_Family::select('*')
            ->where('family_relationship_id', '=', 2)
            ->where('participant_id', '=', $req->participant_id)
            ->where('active_status', '=', true)
            ->first();

        $guardian = Participant_Family::select('*')
            ->where('family_relationship_id', '=', 3)
            ->where('participant_id', '=', $req->participant_id)
            ->where('active_status', '=', true)
            ->first();


        $is_guardian = ($guardian != null) ? true : false;

        return response()->json([
            'father_name' => ($father == null) ? null : $father->family_name,
            'father_mobile_phone_number' => ($father == null) ? null : $father->mobile_phone_number,
            'father_identify_number' => ($father == null) ? null : $father->identify_number,
            'mother_name' => ($mother == null) ? null : $mother->family_name,
            'mother_mobile_phone_number' => ($mother == null) ? null : $mother->mobile_phone_number,
            'mother_identify_number' => ($mother == null) ? null : $mother->identify_number,
            'guardian_name' => ($guardian == null) ? null : $guardian->family_name,
            'guardian_mobile_phone_number' => ($guardian == null) ? null : $guardian->mobile_phone_number,
            'guardian_identify_number' => ($guardian == null) ? null : $guardian->identify_number,
            'participant_id' => $req->participant_id,
            'is_guardian' => $is_guardian,
        ], 200);
    }

    public function GetNewStudentDocumentData(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->id) {
            $id = ['new_student.id', '=', $req->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($req->document_type_id) {
            $document_type_id = ['sd.document_type_id', '=', $req->document_type_id];
        } else {
            $document_type_id = [$filter, '=', '1'];
        }

        $sub_document = "(
            select
                a.selection_path_id,
                b.name as selection_path,
                a.new_student_document_type_id,
                c.name as new_student_document_type,
                c.document_type_id
            from
                mapping_new_student_document_path as a
            join selection_paths as b on
                a.selection_path_id = b.id
            join new_student_document_type as c on
                a.new_student_document_type_id = c.id
            order by
                a.selection_path_id asc,
                a.new_student_document_type_id asc
        ) as sd";

        $data = New_Student::select(
            'new_student.id',
            'new_student.participant_id',
            'new_student.registration_number',
            'sd.selection_path_id',
            'sd.selection_path',
            'sd.new_student_document_type_id',
            'sd.new_student_document_type',
            'sd.document_type_id'
        )
            ->join('registrations as r', 'new_student.registration_number', '=', 'r.registration_number')
            ->join(DB::raw($sub_document), 'r.selection_path_id', '=', 'sd.selection_path_id')
            ->where([$id, $document_type_id])
            ->orderBy('sd.new_student_document_type_id', 'ASC')
            ->get();

        $result = array();

        foreach ($data as $key => $value) {
            switch ($value['document_type_id']) {
                case 1:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 1);
                    break;
                case 2:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 2);
                    break;
                case 4:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 4);
                    break;
                case 5:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 5);
                    break;
                case 6:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 6);
                    break;
                case 7:
                    $value['document'] = New_Student_Document_Type::GetDocumentReportCard($value['registration_number'], 7);
                    break;
                case 12:
                    $value['document'] = New_Student_Document_Type::GetDocumentUtbk($value['registration_number'], 12);
                    break;
                case 29:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 29);
                    break;
                case 30:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 30);
                    break;
                case 31:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 31);
                    break;
                case 32:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 32);
                    break;
                case 33:
                    $value['document'] = New_Student_Document_Type::GetDocumentParticipant($value['participant_id'], 33);
                    break;
            }

            array_push($result, $value);
        }

        return response()->json($result, 200);
    }

    public function GetNewStudentDocumentStatus(Request $req)
    {
        $filter = DB::raw('1');

        if ($req->registration_number) {
            $registration_number = ['ns.registration_number', '=', $req->registration_number];
        } else {
            $registration_number = [$filter, '=', 1];
        }

        if ($req->selection_path_id) {
            $selection_path_id = ['mapping_new_student_document_path.selection_path_id', '=', $req->selection_path_id];
        } else {
            $selection_path_id = [$filter, '=', 1];
        }

        //yng dipakai buat left join participant, raport dan utbk
        $data = Mapping_New_Student_Document_Type::select(
            'ns.id as new_student_id',
            'ns.registration_number',
            'ns.participant_id',
            'mapping_new_student_document_path.selection_path_id',
            'dt.id as document_type_id',
            'dt.name as document_type_name',
            DB::raw('case
                when dr.approval_final_status_int is not null then dr.approval_final_status_int
                when pd.approval_final_status_int is not null then pd.approval_final_status_int
                when du.approval_final_status_int is not null then du.approval_final_status_int
                else null end as approval_final_status_int
            '),
            DB::raw('case
                when dr.approval_final_status is not null then dr.approval_final_status
                when pd.approval_final_status is not null then pd.approval_final_status
                when du.approval_final_status is not null then du.approval_final_status
                else null end as approval_final_status
            '),
            DB::raw('case
                when dr.document_id is not null then dr.document_id
                when pd.document_id is not null then pd.document_id
                when du.document_id is not null then du.document_id
                else null end as document_id
            '),
            DB::raw("case
                when dr.url is not null then dr.url
                when pd.url is not null then pd.url
                when du.url is not null then du.url
                else null end as url
            ")
        )
            ->join('new_student_document_type as nsdt', 'mapping_new_student_document_path.new_student_document_type_id', '=', 'nsdt.id')
            ->join('document_type as dt', 'nsdt.document_type_id', '=', 'dt.id')
            ->join('registrations as r', 'mapping_new_student_document_path.selection_path_id', '=', 'r.selection_path_id')
            ->join('new_student as ns', 'r.registration_number', '=', 'ns.registration_number')
            ->leftJoin(DB::raw('(
                select
                    participant_documents.participant_id,
                    participant_documents.id as participant_document_id,
                    d.id as document_id,
                    dt.id as document_type_id,
                    d.url,
                    case when d.approval_final_status = true then 2 when d.approval_final_status = false then 1 else null end as approval_final_status_int,
                    d.approval_final_status as approval_final_status,
                    dt.type
                from
                    participant_documents
                inner join documents as d on
                    participant_documents.document_id = d.id
                inner join document_type as dt on
                    d.document_type_id = dt.id
                where
                    d.document_type_id is not null
            ) as pd'), function ($join) {
                $join->on('dt.id', '=', 'pd.document_type_id')
                    ->on('r.participant_id', '=', 'pd.participant_id');
            })
            ->leftJoin(DB::raw('(
                select
                    document_report_card.id as document_report_card_id,
                    d.id as document_id,
                    dt.id as document_type_id,
                    document_report_card.registration_number,
                    d.url,
                    case when d.approval_final_status = true then 2 when d.approval_final_status = false then 1 else null end as approval_final_status_int,
                    d.approval_final_status as approval_final_status,
                    dt.type
                from
                    document_report_card
                inner join documents as d on
                    document_report_card.document_id = d.id
                inner join document_type as dt on
                    d.document_type_id = dt.id
            ) as dr'), function ($join) {
                $join->on('dt.id', '=', 'dr.document_type_id')
                    ->on('r.registration_number', '=', 'dr.registration_number');
            })
            ->leftJoin(DB::raw('(
                select
                    du.registration_number ,
                    du.id as document_utbk_id,
                    d.id as document_id,
                    dt.id as document_type_id,
                    d.url,
                    case when d.approval_final_status = true then 2 when d.approval_final_status = false then 1 else null end as approval_final_status_int,
                    d.approval_final_status as approval_final_status,
                    dt.type
                from
                    document_utbk as du 
                inner join documents as d on
                    du.document_id = d.id
                inner join document_type as dt on
                    d.document_type_id = dt.id
                where
                    d.document_type_id is not null
            ) as du'), function ($join) {
                $join->on('dt.id', '=', 'du.document_type_id')
                    ->on('r.registration_number', '=', 'du.registration_number');
            })
            ->where([$registration_number, $selection_path_id])
            ->get();

        $result = array();

        //dimasukkan dalam perulangan dikarenakan approval_final_status
        //tidak bisa ditambahkan dalam where karena approval_final_status hasil dari case when
        foreach ($data as $key => $value) {
            if (isset($req->approval_final_status) != null) {
                if ($req->approval_final_status == 'true') {
                    if ($value['approval_final_status_int'] == 2) {
                        array_push($result, $value);
                    }
                }

                if ($req->approval_final_status == 'false') {
                    if ($value['approval_final_status_int'] == 1) {
                        array_push($result, $value);
                    }
                }
            } else {
                array_push($result, $value);
            }
        }

        return response()->json($result, 200);
    }

    public function GetMoodleExamAttempts(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_exam_attempts';

            $formParam['courseid'] = $req->courseid;
            $formParam['limit'] = $req->limit;
            $formParam['offset'] = $req->offset;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleCategoryList(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_category_list';

            $formParam['limit'] = $req->limit;
            $formParam['offset'] = $req->offset;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleCourseList(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_course_list';

            $formParam['limit'] = $req->limit;
            $formParam['offset'] = $req->offset;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleSectionList(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_section_list';

            $formParam['course'] = $req->course;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleQuizList(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_quiz_list';

            $formParam['course'] = $req->course;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleGroupList(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_group_list';

            $formParam['course'] = $req->course;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetMoodleGrades(Request $req)
    {
        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_user_grades';

            $formParam['userid'] = $req->userid;

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            return $response;
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //functiom for getting program study list by admin faculty
    public function GetProgramStudyByAdminFaculty(Request $req)
    {
        $by = $req->header("X-I");

        //get data
        $role = Framework_Mapping_User_Role::select('admin_faculty_id', 'id', 'oauth_role_id')
            ->where('oauth_role_id', '=', 1025)
            ->where('user_id', '=', $by)
            ->first();

        //validate data
        if ($role == null) return [];

        //get study programs by faculty id
        $data = Study_Program::select(
            'study_programs.classification_id as study_program_id',
            'study_programs.study_program_branding_name as study_program_name',
            'study_programs.faculty_id',
            'study_programs.faculty_name',
            'study_programs.category',
            'study_programs.acronim',
            'study_programs.acreditation'
        )
            ->join('mapping_path_program_study as mpps', 'study_programs.classification_id', '=', 'mpps.program_study_id')
            ->where('study_programs.faculty_id', '=', $role->admin_faculty_id)
            ->where('mpps.selection_path_id', '=', $req->selection_path_id)
            ->where('mpps.active_status', '=', true)
            ->get();

        return response()->json($data, 200);
    }

    public function GenerateTranscriptCreditCard(Request $req)
    {
        $by = $req->header('X-I');

        //get data transcript
        $dt = Document_Transcript::select(
            'document_transcript.*',
            'p.fullname'
        )
            ->join('registrations as r', 'document_transcript.registration_number', '=', 'r.registration_number')
            ->join('participants as p', 'r.participant_id', '=', 'p.id')
            ->where('document_transcript.id', '=', $req->document_transcript_id)
            ->first();

        $mdt = Mapping_Transcript_Participant::where('document_transcript_id', '=', $dt->id)
            ->get();

        $data = [
            'document_transcript' => $dt,
            'mapping_document_transcript' => $mdt
        ];

        try {
            $pdf = PDF::loadView('transcript', $data)
                ->setPaper('a4', 'potrait');

            $filenames = 'transcript_card/' . $dt->registration_number . '_transcript_card.pdf';
            $content = $pdf->download()->getOriginalContent();
            Storage::put($filenames, $content);

            $path = env('FTP_URL') . $filenames;

            //update printed time, by and url
            Document_Transcript::find($req->document_transcript_id)->update([
                'printed_at' => Carbon::now(),
                'printed_by' => $by,
                'printed_url' => $path
            ]);

            return response()->json(['urls' => $path], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to generated registration card',
                'error' => $th->getMessage(),
                'urls' => null
            ], 500);
        }
    }

    //function for getting exam group id from program study choose
    function GetExamGroupFromRegistration($registration_number)
    {
        $program_studies = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.registration_number',
            'mapping_registration_program_study.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->join('mapping_session_study_program as msp', 'sp.classification_id', '=', 'msp.classification_id')
            ->where('mapping_registration_program_study.registration_number', '=', $registration_number)
            ->get();

        $s_one = false;
        $s_two = false;
        $s_three = false;

        foreach ($program_studies as $key => $value) {
            if ($value['session_one'] == true) $s_one = true;
            if ($value['session_two'] == true) $s_two = true;
            if ($value['session_three'] == true) $s_three = true;
        }

        $exam_group_ids = array();

        if ($s_one && $s_two && $s_three) {
            array_push($exam_group_ids, 4);
        } else {
            if ($s_one) {
                array_push($exam_group_ids, 1);
            }

            if ($s_two) {
                array_push($exam_group_ids, 2);
            }

            if ($s_three) {
                array_push($exam_group_ids, 3);
            }
        }

        return $exam_group_ids;
    }

    //function for getting exam quiz id from program study choose
    function GetExamQuizFromRegistration($registration_number)
    {
        $program_studies = Mapping_Registration_Program_Study::select(
            'mapping_registration_program_study.registration_number',
            'mapping_registration_program_study.program_study_id',
            'msp.session_one',
            'msp.session_two',
            'msp.session_three'
        )
            ->join('study_programs as sp', 'mapping_registration_program_study.program_study_id', '=', 'sp.classification_id')
            ->join('mapping_session_study_program as msp', 'sp.classification_id', '=', 'msp.classification_id')
            ->where('mapping_registration_program_study.registration_number', '=', $registration_number)
            ->get();

        $s_one = false;
        $s_two = false;
        $s_three = false;

        foreach ($program_studies as $key => $value) {
            if ($value['session_one'] == true) $s_one = true;
            if ($value['session_two'] == true) $s_two = true;
            if ($value['session_three'] == true) $s_three = true;
        }

        $exam_quiz_ids = array();

        if ($s_one) {
            array_push($exam_quiz_ids, 1);
        }

        if ($s_two) {
            array_push($exam_quiz_ids, 2);
        }

        if ($s_three) {
            array_push($exam_quiz_ids, 3);
        }

        return $exam_quiz_ids;
    }


    public function GetPassingGradeProgramStudy(Request $req)
    {
        $subNotIn = Passing_Grade::select('passing_grades.program_study_id')
            ->join('mapping_path_year as mpy', 'passing_grades.mapping_path_year_id', '=', 'mpy.id')
            ->where('passing_grades.active_status', '=', true)
            ->where('mpy.selection_path_id', '=', $req->selection_path_id)
            ->get();

        $program_study_not_in = array();

        foreach ($subNotIn as $key => $value) {
            array_push($program_study_not_in, $value['program_study_id']);
        }

        $data = Mapping_Path_Study_Program::select(
            'sp.classification_id as id',
            'sp.study_program_branding_name as study_program_name',
            'sp.study_program_name_en',
            'sp.acronim',
            'sp.faculty_id',
            'sp.faculty_name',
            'msp.selection_path_id'
        )
            ->join('study_programs as sp', 'msp.program_study_id', '=', 'sp.classification_id')
            ->where('msp.selection_path_id', '=', $req->selection_path_id)
            ->where('msp.active_status', '=', true)
            ->whereNotIn('msp.program_study_id', $program_study_not_in)
            ->get();


        return response()->json($data, 200);
    }

    public function GetMoodleExamGrades(Request $req)
    {
        $registration = Registration::select(
            'registrations.registration_number',
            'registrations.participant_id',
            'registrations.path_exam_detail_id',
            'registrations.selection_path_id',
            'mc.id as moodle_course_id',
            'mc.fullname as moodle_course_fullname'
        )
            ->join('path_exam_details as ped', 'registrations.path_exam_detail_id', '=', 'ped.id')
            ->join('moodle_courses as mc', 'ped.id', '=', 'mc.path_exam_detail_id')
            ->where('registrations.registration_number', '=', $req->registration_number)
            ->first();

        //validate
        if ($registration == null) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'Registration not found'
            ], 200);
        }

        //getting group choose
        $groups = Moodle_Groups::select(
            'moodle_groups.id as moodle_group_id',
            'moodle_groups.moodle_course_id',
            'moodle_groups.name',
            'moodle_groups.exam_group_id'
        )
            ->where('moodle_groups.moodle_course_id', '=', $registration->moodle_course_id)
            ->whereIn('moodle_groups.exam_group_id', $this->GetExamGroupFromRegistration($registration->registration_number))
            ->get();

        //getting quizez
        $quizes = Moodle_Quizes::select(
            'id as moodle_quiz_id'
        )
            ->where('moodle_quizes.moodle_course_id', '=', $registration->moodle_course_id)
            ->whereIn('moodle_quizes.type', $this->GetExamQuizFromRegistration($registration->registration_number))
            ->get();

        try {
            $url = env('CBT_MOODLE_URL');
            $http = new Client(['verify' => false]);

            $formParam['wstoken'] = env('CBT_MOODLE_TOKEN');
            $formParam['moodlewsrestformat'] = 'json';
            $formParam['wsfunction'] = 'local_trisakti_api_get_exam_grades';

            $i = 0;
            foreach ($groups as $kg => $vg) {
                foreach ($quizes as $kq => $vq) {
                    $formParam['exams'][$i]['groupid'] = $vg->moodle_group_id;
                    $formParam['exams'][$i]['quizid'] = $vq->moodle_quiz_id;
                    $i++;
                }
            }

            $request = $http->get($url, [
                'query' => $formParam
            ]);

            $response = json_decode($request->getBody(), true);

            $grade = null;
            $total = 0;

            foreach ($response['data'] as $kd => $vd) {

                foreach ($vd['result'] as $kr => $vr) {
                    if ($vr['userid'] == $registration->participant_id) {
                        $grade += $kr['score'];
                        $total++;
                    }
                }
            }

            //validate grade
            if ($total == 0) {
                return response()->json([
                    'status' => 'Failed',
                    'grade' => null,
                    'message' => 'Partisipan belum melakukan ujian'
                ], 200);
            }

            return response()->json([
                'status' => 'Success',
                'grade' => (float) $grade / $total,
                'message' => null
            ], 200);
        } catch (\Exception $e) {
            return response([
                'status' => 'Failed',
                'message' => 'Gagal mendaftarkan data kedalam moodle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetCategories(Request $req)
    {
        $data = Category::all();
        return response()->json($data);
    }

    public function GetForms(Request $req)
    {
        $data = Form::all();
        return response()->json($data);
    }

    public function GetSchedules(Request $req)
    {
        $data = Schedule::all();
        return response()->json($data);
    }

    public function GetDocumentCategories(Request $req)
    {
        $data = Document_Categories::all();
        return response()->json($data);
    }

    public function GetSelectionCategories(Request $req)
    {
        $data = Selection_Categories::all();
        return response()->json($data);
    }

    public function GetStudentInterest(Request $req)
    {
        $data = Education_Major::all();
        return response()->json($data);
    }

    public function GetMappingProdiCategory(Request $req)
    {
        $data = Mapping_Prodi_Category::select('*');
        if($req->id){
            $data->where('prodi_fk', $req->id);
        }
        
        return response()->json($data->get());
    }

    public function GetMappingProdiFormulir(Request $req)
    {
        $data = Mapping_Prodi_Formulir::all();
        return response()->json($data);
    }

    public function GetMappingProdiBiaya(Request $req)
    {
        $data = Mapping_Prodi_Biaya::all();
        return response()->json($data);
    }

    public function GetMasterMataPelajaran(Request $req)
    {
        $data = Master_Matpel::all();
        return response()->json($data);
    }

    public function GetMasterKelas(Request $req)
    {
        $data = Master_kelas::all();
        return response()->json($data);
    }

    public function GetMappingProdiMatapelajaran(Request $req)
    {
        $data = Mapping_Prodi_Matapelajaran::select('id' , 'prodi_id' , 'nama_prodi' , 'pelajaran_id' , 'mata_pelajaran');
        if($req->id){
            $data->where('prodi_id', $req->id);
        }
        
        return response()->json($data->get());
    }

    public function GetMappingProdiMinat(Request $req)
    {
        $data = Mapping_Prodi_Minat::select('id' , 'prodi_id' , 'nama_prodi' , 'minat_id', 'nama_minat');
        if($req->id){
            $data->where('prodi_id', $req->id);
        }
        
        return response()->json($data->get());
    }

    public function GetTransferCredit(Request $req)
    {
        $data = Transfer_Credit::select('*');
        if($req->participant_id){
            $data->where('participant_id', $req->participant_id);
        }
        
        return response()->json($data->get());
    }

    public function GetPackageQuestionUsers(Request $req)
    {
        $data = CBT_Package_Question_Users::all();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function GetMasterPackage(Request $req)
    {
        $result = [];
        $data = Master_Package::all();
        foreach ($data as $key => $paket) {
            $result[$key] = $paket;
            $result[$key]['detail'] = Master_Package_Angsuran::where('package_id', $paket->id)->orderBy('angsuran_ke', 'ASC')->get();
        }
        
        return [
            'data' => $result,
        ];
    }
}
