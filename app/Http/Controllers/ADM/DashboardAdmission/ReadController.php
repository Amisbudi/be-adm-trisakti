<?php

namespace App\Http\Controllers\ADM\DashboardAdmission;

use App\Http\Controllers\Controller;
use App\Http\Models\ADM\DashboardAdmission\DimActivationPin;
use App\Http\Models\ADM\DashboardAdmission\DimDate;
use App\Http\Models\ADM\DashboardAdmission\DimFaculty;
use App\Http\Models\ADM\DashboardAdmission\DimListOfInvoiceItem;
use App\Http\Models\ADM\DashboardAdmission\DimProvince;
use App\Http\Models\ADM\DashboardAdmission\DimQuestion;
use App\Http\Models\ADM\DashboardAdmission\DimSchoolYear;
use App\Http\Models\ADM\DashboardAdmission\DimSelectionPath;
use App\Http\Models\ADM\DashboardAdmission\DimSelectionProgram;
use App\Http\Models\ADM\DashboardAdmission\FactRegExamLocation;
use App\Http\Models\ADM\DashboardAdmission\FactRegParticipant;
use App\Http\Models\ADM\DashboardAdmission\FactRegPin;
use App\Http\Models\ADM\DashboardAdmission\FactRegQuestionAnswer;
use App\Http\Models\ADM\DashboardAdmission\FactRegRegistration;
use App\Http\Models\ADM\DashboardAdmission\FactRegPaidTransaction;
use App\Http\Models\ADM\DashboardAdmission\FactRegPaymentReport;
use App\Http\Models\ADM\DashboardAdmission\FactRegYearTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadController extends Controller
{
    //fungsi untuk menampilkan filter year
    public function YearFilter()
    {
        $response = DimDate::select("year")
            ->where("school_year", "!=", "n/a")
            ->groupBy("year")
            ->orderBy("year")
            ->get();

        return response()->json($response, 200);
    }

    //fungsi untuk menampilkan filter selection program
    public function SelectionProgramFilter()
    {
        $response = DimSelectionProgram::select("id", "name")
            ->orderBy("name")
            ->get();

        return response()->json($response, 200);
    }

    //fungsi untuk menampilkan filter selection path
    public function SelectionPathFilter(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->selection_program_id != null) {
            $selection_program_id = ["selection_program_id", "=", $request->selection_program_id];
        } else {
            $selection_program_id = [$filter, "=", 1];
        }

        $response = DimSelectionPath::select("id", "name", "selection_program_id")
            ->where([$selection_program_id])
            ->orderBy("name")
            ->get();

        return response()->json($response, 200);
    }

    //api top ten participant provinsi
    public function TopTenParticipantProvince(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_participants.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegParticipant::select(
            DB::raw("SUM(fact_reg_participants.total_participant) as total"),
            "province.id as province_id",
            "province.name as province_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_participants.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_participants.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_cities as city", "fact_reg_participants.cities_id", "=", "city.id")
            ->leftjoin("dim_provinces as province", "city.province_id", "=", "province.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->whereNotIn('city.id', [600])
            ->whereNotIn('province.id', [35])
            ->groupBy("province.id")
            ->orderBy("total", "DESC")
            ->limit(10)
            ->get();

        return response()->json($result, 200);
    }

    //api top ten participant city
    public function TopTenParticipantCity(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_participants.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegParticipant::select(
            DB::raw("SUM(fact_reg_participants.total_participant) as total"),
            "city.id as city_id",
            "city.name as city_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_participants.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_participants.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_cities as city", "fact_reg_participants.cities_id", "=", "city.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->whereNotIn('city.id', [600])
            ->groupBy("city.id")
            ->orderBy("total", "DESC")
            ->limit(10)
            ->get();

        return response()->json($result, 200);
    }

    //api top ten participant school
    public function TopTenParticipantSchool(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_participants.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegParticipant::select(
            DB::raw("SUM(fact_reg_participants.total_participant) as total"),
            "school.id as school_id",
            "school.name as school_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_participants.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_participants.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_schools as school", "fact_reg_participants.school_id", "=", "school.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->whereNotIn('school.id', [33195])
            ->groupBy("school.id")
            ->orderBy("total", "DESC")
            ->limit(10)
            ->get();

        return response()->json($result, 200);
    }

    //api top ten participant faculty
    public function TopTenParticipantFaculty(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_participants.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegParticipant::select(
            "faculty.id as faculty_id",
            "faculty.name as faculty_name",
            DB::raw("SUM(fact_reg_participants.total_participant) as total")
        )
            ->leftjoin("dim_date as date", "fact_reg_participants.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_participants.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_studyprograms as studyprogram", "fact_reg_participants.studyprograms_id", "=", "studyprogram.id")
            ->leftjoin("dim_faculties as faculty", "studyprogram.faculty_id", "=", "faculty.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->whereNotNull("faculty.id")
            ->groupBy("faculty.id")
            ->orderBy("total", "DESC")
            ->limit(10)
            ->get();

        return response()->json($result, 200);
    }

    //api top ten participant program study
    public function TopTenParticipantProgramStudy(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_participants.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegParticipant::select(
            "studyprogram.id as study_program_id",
            "studyprogram.name as study_program_name",
            DB::raw("SUM(fact_reg_participants.total_participant) as total")
        )
            ->leftjoin("dim_date as date", "fact_reg_participants.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_participants.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_studyprograms as studyprogram", "fact_reg_participants.studyprograms_id", "=", "studyprogram.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->groupBy("studyprogram.id")
            ->whereNotNull("studyprogram.id")
            ->orderBy("total", "DESC")
            ->limit(10)
            ->get();

        return response()->json($result, 200);
    }

    //Pendaftar total
    public function TotalRegistration(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["path.id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $response = array();

        $response["total"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->sum("fact_reg_registration.total_participant");

        $response["total_akun_pendaftar"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->whereNotNull("fact_reg_registration.verification_status")
            ->sum("fact_reg_registration.total_participant");

        $response["total_akun_aktif"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->where("fact_reg_registration.verification_status", "=", true)
            ->sum("fact_reg_registration.total_participant");

        $response["total_pesan_no_trans"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->whereNotNull("fact_reg_registration.payment_status_id")
            ->sum("fact_reg_registration.total_participant");

        $response["total_pembeli_pin"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->where("fact_reg_registration.amount_of_pin_cost", "!=", null)
            ->sum("fact_reg_registration.total_participant");

        $response["total_pemilih_prodi"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->whereNotNull("fact_reg_registration.studyprograms_id")
            ->sum("fact_reg_registration.total_participant");

        $response["total_camaba_lulus"] = $this->GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
            ->where("pass_status.id", "=", "1")
            ->sum("fact_reg_registration.total_participant");

        return response()->json($response, 200);
    }

    public function GetRegistrationTotal($yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
    {
        return FactRegRegistration::leftjoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_pass_status as pass_status", "fact_reg_registration.pass_status_id", "=", "pass_status.id")
            ->leftjoin("dim_activation_pin as pin", "fact_reg_registration.activation_pin_id", "=", "pin.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter]);
    }

    //Pendaftar per Fakultas
    public function TotalRegistrationByFaculty(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_registration.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegRegistration::select(
            DB::raw("SUM(fact_reg_registration.total_participant) as total"),
            "faculty.id as faculty_id",
            "faculty.name as faculty_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_studyprograms as studyprogram", "fact_reg_registration.studyprograms_id", "=", "studyprogram.id")
            ->leftjoin("dim_faculties as faculty", "studyprogram.faculty_id", "=", "faculty.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->whereNotNull("faculty.id")
            ->groupBy("faculty.id")
            ->get()
            ->toArray();


        //total all data for percentage
        $total = array_sum(array_column($result, "total"));

        $response = array();
        foreach ($result as $key => $value) {
            //validate divined
            if ($value["total"] == 0 || $total == 0) {
                $percentage = "0%";
            } else {
                //calculate percentage
                $percentage = number_format($value["total"] / $total * 100, 2) . "%";
            }

            //add percentage column
            $value["percentage"] = $percentage;

            array_push($response, $value);
        }

        return response()->json($response, 200);
    }

    //Pendaftar per program study
    public function TotalRegistrationByProgramStudy(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_registration.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        if ($request->faculty_id != null) {
            $facultyFilter = ["faculty.id", "=", $request->faculty_id];
        } else {
            $facultyFilter = [$filter, "=", 1];
        }

        $result = FactRegRegistration::select(DB::raw("SUM(fact_reg_registration.total_participant) as total"), "studyprogram.id as study_program_id", "studyprogram.name as study_program_name")
            ->join("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->join("dim_studyprograms as studyprogram", "fact_reg_registration.studyprograms_id", "=", "studyprogram.id")
            ->join("dim_faculties as faculty", "studyprogram.faculty_id", "=", "faculty.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter, $facultyFilter])
            ->groupBy("studyprogram.id")
            ->get();

        return response()->json($result, 200);
    }

    //function for get all province
    public function AllProvince()
    {
        $result = DimProvince::all();
        return response()->json($result, 200);
    }

    //Pendaftar per provinsi
    public function TotalRegistrationByProvince(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_registration.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        if ($request->province_id != null) {
            $provinceFilter = ["province.id", "=", $request->province_id];
        } else {
            $provinceFilter = [$filter, "=", 1];
        }

        $result = FactRegRegistration::select(
            DB::raw("SUM(fact_reg_registration.total_participant) as total"),
            "province.id as province_id",
            "province.name as province_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_cities as city", "fact_reg_registration.cities_id", "=", "city.id")
            ->leftjoin("dim_provinces as province", "city.province_id", "=", "province.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter, $provinceFilter])
            ->groupBy("province.id")
            ->orderBy("province.id")
            ->get();

        return response()->json($result, 200);
    }

    //Pendaftar per gender
    public function TotalRegistrationByGender(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_registration.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegRegistration::select(
            DB::raw("SUM(fact_reg_registration.total_participant) as total"),
            "gender.id as gender_id",
            "gender.name as gender_name"
        )
            ->leftjoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_gender as gender", "fact_reg_registration.gender_id", "=", "gender.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->groupBy("gender.id")
            ->orderBy("gender.id")
            ->get()
            ->toArray();

        //total all gender
        $total = array_sum(array_column($result, "total"));

        $response = array();
        foreach ($result as $key => $value) {
            //validate divined
            if ($value["total"] == 0 || $total == 0) {
                $percentage = "0%";
            } else {
                //calculate percentage
                $percentage = number_format($value["total"] / $total * 100, 2) . "%";
            }

            //add percentage column
            $value["percentage"] = $percentage;

            array_push($response, $value);
        }

        return response()->json($response, 200);
    }

    //api untuk get all faculty
    public function AllFaculty()
    {
        $result = DimFaculty::all();
        return response()->json($result, 200);
    }

    //api total exam location
    public function TotalExamLocation(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_exam_location.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $query = FactRegExamLocation::join("dim_date as date", "fact_reg_exam_location.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_exam_location.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->sum("fact_reg_exam_location.total_location");

        $result = ["total" => $query];

        return response()->json($result, 200);
    }

    //api exam location
    public function ExamLocation(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_exam_location.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $result = FactRegExamLocation::select("school.name as school_name", "city.name as city_name")
            ->join("dim_date as date", "fact_reg_exam_location.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_exam_location.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->join("dim_schools as school", "fact_reg_exam_location.school_id", "=", "school.id")
            ->join("dim_cities as city", "school.city_id", "=", "city.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->get();

        return response()->json($result, 200);
    }

    //api purchased pin / Pembeli PIN
    public function PurchasedPin(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["path.id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $purchased = FactRegPin::leftjoin("dim_date as date", "fact_reg_pin.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_pin.selection_paths_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->where('fact_reg_pin.status_pin_id', '=', 1)
            ->sum("fact_reg_pin.total_participant");

        $target = FactRegYearTarget::select(
            DB::raw("SUM(fact_reg_year_target.pin) as total_target")
        )
            ->join("dim_date as date", "fact_reg_year_target.date_id", "date.id")
            ->where([$yearStartFilter, $yearEndFilter])
            ->first();

        // total keseluruhan
        $totalParticipant = $purchased;
        $totalTarget = $target->total_target;

        $total = $totalParticipant + $totalTarget;

        if ($total == 0) {
            $percentagePembeli = 0;
            $percentageTargetPembeli = 0;
        } else {
            if ($totalParticipant == 0) {
                $percentagePembeli = 0;
            } else {
                $percentagePembeli = number_format($totalParticipant / $total * 100, 2);
            }

            if ($totalTarget == 0) {
                $percentageTargetPembeli = 0;
            } else {
                $percentageTargetPembeli = number_format($totalTarget / $total * 100, 2);
            }
        }

        $data = [
            "pembeli" => $totalParticipant,
            "persentase_pembeli" => $percentagePembeli . "%",
            "target_pembeli" => (int) $totalTarget,
            "persentase_target_pembeli" => $percentageTargetPembeli . "%"
        ];

        return response()->json($data, 200);
    }

    //api purchased pin / Pembeli PIN
    public function IncomePurchasedPin(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_pin.selection_paths_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $price = FactRegPaymentReport::select(
            DB::raw("SUM(fact_reg_payment_report.total_income) as total_price")
        )
            ->join("dim_date as date", "fact_reg_payment_report.date_id", "date.id")
            ->where([$yearStartFilter, $yearEndFilter])
            ->get()
            ->toArray();

        $total_pin = FactRegPin::select(
            DB::raw("sum(fact_reg_pin.total_participant) as total"),
            DB::raw("CASE WHEN price.price IS NULL THEN '0' ELSE price.price END AS price")
        )
            ->leftjoin("dim_date as date", "fact_reg_pin.date_id", "date.id")
            ->leftjoin("dim_selection_paths as path", "fact_reg_pin.selection_paths_id", "=", "path.id")
            ->leftjoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->leftjoin("dim_price as price", "fact_reg_pin.price_id", "=", "price.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->where('fact_reg_pin.status_pin_id', '=', 1)
            ->groupBy("price.id")
            ->get()
            ->toArray();

        $data = [
            "total_pin" => array_sum(array_column($total_pin, 'total')),
            'total_price' => array_sum(array_column($price, 'total_price')),
            "pin" => $total_pin
        ];

        return response()->json($data, 200);
    }

    //api achievement purchased pin / pencapaian pembelian PIN
    public function AchievementPurchasedPin(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_pin.selection_paths_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $query = FactRegPin::select("path.name as path_name", DB::raw("sum(fact_reg_pin.amount_of_pin_cost) as total_price"), DB::raw("sum(fact_reg_pin.total_participant) as total_pin"))
            ->join("dim_date as date", "fact_reg_pin.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_pin.selection_paths_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->groupBy("path.id")
            ->get();

        $result = array();

        foreach ($query as $key => $value) {
            $data = [
                "path_name" => $value["path_name"],
                "total_pin" => (float) $value["total_pin"],
                "total_price" => (float) $value["total_price"],
            ];

            array_push($result, $data);
        }

        return response()->json($result, 200);
    }

    //fungsi untuk menghitung jumlah dari jawaban
    public function CountQuestionareAnswer($questionId, $answerId, $yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter)
    {
        return FactRegQuestionAnswer::select(
            "fact_reg_questions_answer.question_id",
            "fact_reg_questions_answer.answer_id",
            DB::raw("SUM(fact_reg_questions_answer.total_participant) as answer_total")
        )
            ->join("dim_date as date", "fact_reg_questions_answer.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_questions_answer.selection_paths_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->where("fact_reg_questions_answer.question_id", "=", $questionId)
            ->where("fact_reg_questions_answer.answer_id", "=", $answerId)
            ->groupBy("fact_reg_questions_answer.answer_id")
            ->groupBy("fact_reg_questions_answer.question_id")
            ->sum("fact_reg_questions_answer.total_participant");
    }

    //api quisionare
    public function Questionare(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_questions_answer.selection_paths_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        //temp result
        $result = array();

        //data seluruh kuisioner dan jawaban
        $raw = FactRegQuestionAnswer::QuestionWithAnswer();

        foreach ($raw as $keyQuestion => $valueQuestion) {

            $questionId = $valueQuestion["question_id"];
            $questionContent = $valueQuestion["question"];

            //temp hasil jawaban
            $tmpAnswer = array();

            foreach ($valueQuestion["answer"] as $keyAnswer => $valueAnswer) {

                $answerId = $valueAnswer["answer_id"];
                $answerContent = $valueAnswer["answer_name"];
                //ambil total nya
                $total = $this->CountQuestionareAnswer($questionId, $answerId, $yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter);

                $resultAnswer = [
                    "answer_id" => $answerId,
                    "answer_content" => $answerContent,
                    "answer_total" => (float) $total,
                ];

                array_push($tmpAnswer, $resultAnswer);
            }

            //untuk perhitungan percentase answer
            $totalAnswer = array_sum(array_column($tmpAnswer, "answer_total"));

            $answer = array();
            foreach ($tmpAnswer as $key => $value) {

                if ($totalAnswer != 0) {
                    $value["answer_percentage"] = number_format($value["answer_total"] / $totalAnswer * 100, 2) . "%";
                } else {
                    $value["answer_percentage"] = "0%";
                }

                array_push($answer, $value);
            }

            $resultQuestion = [
                "question_id" => $questionId,
                "question_content" => $questionContent,
                "answer" => $answer
            ];

            array_push($result, $resultQuestion);
        }

        return response()->json($result, 200);
    }

    //api laporan akhir
    public function FinalReport(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_paid_transaction.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $invoices = DimListOfInvoiceItem::all();

        $result = array();

        foreach ($invoices as $key => $value) {

            $total = FactRegPaidTransaction::leftJoin("dim_date as date", "fact_reg_paid_transaction.date_id", "date.id")
                ->leftJoin("dim_selection_paths as path", "fact_reg_paid_transaction.selection_path_id", "=", "path.id")
                ->leftJoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
                ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
                ->where("fact_reg_paid_transaction.list_invoice_item_id", "=", $value["id"])
                ->groupBy("fact_reg_paid_transaction.list_invoice_item_id")
                ->sum("fact_reg_paid_transaction.amount_of_transaction");

            if ($total < 1000000) {
                $format = number_format($total);
            } else if ($total < 1000000000) {
                $format = number_format($total / 1000000, 2) . ' JT';
            } else if ($total < 1000000000000) {
                $format = number_format($total / 1000000000, 2) . ' M';
            } else {
                $format = number_format($total / 1000000000000, 2) . ' T';
            }

            $data = [
                "id" => $value["id"],
                "name" => $value["name"],
                "total" => (float) $total,
                "total_convert" => $format
            ];

            array_push($result, $data);
        }

        return response()->json($result, 200);
    }

    //api laporan akhir registrasion faculty onsite
    public function RegistrationOnsiteFaculty(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_paid_transaction.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $query = FactRegPaidTransaction::select(
            "faculty.id",
            "faculty.name",
            DB::raw("SUM(fact_reg_paid_transaction.total_participants) as total")
        )
            ->join("dim_date as date", "fact_reg_paid_transaction.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_paid_transaction.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->join("dim_studyprograms as studyprogram", "fact_reg_paid_transaction.studyprogams_id", "=", "studyprogram.id")
            ->join("dim_faculties as faculty", "studyprogram.faculty_id", "=", "faculty.id")
            ->leftJoin("dim_listofinvoiceitem as invoice", "fact_reg_paid_transaction.list_invoice_item_id", "=", "invoice.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->where("invoice.name", "=", "UP3")
            ->whereNotNull("faculty.id")
            ->groupBy("faculty.id")
            ->orderBy("faculty.id")
            ->get()
            ->toArray();

        //total all onsite
        $total = array_sum(array_column($query, "total"));

        $result = array();
        foreach ($query as $key => $value) {

            if ($total == 0 || $value["total"] == 0) {
                $percentage = "0%";
            } else {
                $percentage = number_format($value["total"] / $total * 100, 2) . "%";
            }

            $data = [
                "faculty_id" => $value["id"],
                "faculty_name" => $value["name"],
                "total" => (float) $value["total"],
                "percentage" => $percentage
            ];

            array_push($result, $data);
        }

        return response()->json($result, 200);
    }

    //api laporan akhir registrasion program study onsite
    public function RegistrationOnsiteProgramStudy(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["fact_reg_paid_transaction.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        if ($request->faculty_id != null) {
            $facultyFilter = ["faculty.id", "=", $request->faculty_id];
        } else {
            $facultyFilter = [$filter, "=", 1];
        }

        $query = FactRegPaidTransaction::select("studyprogram.id", "studyprogram.name", DB::raw("SUM(fact_reg_paid_transaction.total_participants) as total"))
            ->join("dim_date as date", "fact_reg_paid_transaction.date_id", "date.id")
            ->join("dim_selection_paths as path", "fact_reg_paid_transaction.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->join("dim_studyprograms as studyprogram", "fact_reg_paid_transaction.studyprogams_id", "=", "studyprogram.id")
            ->join("dim_faculties as faculty", "studyprogram.faculty_id", "=", "faculty.id")
            ->leftJoin("dim_listofinvoiceitem as invoice", "fact_reg_paid_transaction.list_invoice_item_id", "=", "invoice.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter, $facultyFilter])
            ->where("invoice.name", "=", "UP3")
            ->groupBy("studyprogram.id")
            ->orderBy("total", "DESC")
            ->get();

        $result = array();

        foreach ($query as $key => $value) {
            $data = [
                "study_program_id" => $value["id"],
                "study_program_name" => $value["name"],
                "total" => (float) $value["total"]
            ];

            array_push($result, $data);
        }

        return response()->json($result, 200);
    }

    //Target vs Realisasi Pendaftar (PIN/non-PIN)
    public function CompareTargetWithRealizationParticipant(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["path.id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $target = FactRegYearTarget::select(
            DB::raw("SUM(fact_reg_year_target.pin) as total_target")
        )
            ->leftJoin("dim_date as date", "fact_reg_year_target.date_id", "date.id")
            ->where([$yearStartFilter, $yearEndFilter])
            ->first();

        $realization = FactRegRegistration::select(
            DB::raw("SUM(fact_reg_registration.total_participant) as total_realisasi")
        )
            ->leftJoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftJoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftJoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->first();

        $result = [
            'total_target' => (float) $target->total_target,
            'total_realisasi' => $realization->total_realisasi,
        ];

        return response()->json($result, 200);
    }

    //API Grafik Pendaftar PIN dan Non Pin
    public function ParticipantPinAndNonPin(Request $request) 
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["reg.selection_path_id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $data = DimActivationPin::select(
            "dim_activation_pin.id",
            "dim_activation_pin.name",
            DB::raw("CASE WHEN SUM(reg.total_participant) IS NULL THEN 0 ELSE SUM(reg.total_participant) END AS total")
        )
            ->join("fact_reg_registration as reg", "dim_activation_pin.id", "=", "reg.activation_pin_id")
            ->join("dim_date as date", "reg.date_id", "date.id")
            ->join("dim_selection_paths as path", "reg.selection_path_id", "=", "path.id")
            ->join("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionPathFilter, $selectionProgramFilter])
            ->groupBy("dim_activation_pin.id")
            ->get()
            ->toArray();

        
        $totalsum = array_sum(array_column($data, "total"));

        $result = array();
        foreach ($data as $key => $value) {
            if ($totalsum == 0 || $value["total"] == 0 || $totalsum == null || $value["total"] == null) {
                $percentage = "0%";
            } else {
                $percentage = number_format($value["total"] / $totalsum * 100, 2) . "%";
            }

            $value["percentage"] = $percentage;

            array_push($result, $value);
        }

        return response()->json($result, 200);
    }

    //Target vs Realisasi Pendaftar (PIN/non-PIN)
    public function CompareTargetWithRealizationRegistration(Request $request)
    {
        $filter = DB::raw("1");

        if ($request->start_date != null) {
            $yearStartFilter = ["date.date", ">=", date($request->start_date)];
        } else {
            $yearStartFilter = [$filter, "=", 1];
        }

        if ($request->end_date != null) {
            $yearEndFilter = ["date.date", "<=", date($request->end_date)];
        } else {
            $yearEndFilter = [$filter, "=", 1];
        }

        if ($request->selection_program_id != null) {
            $selectionProgramFilter = ["program.id", "=", $request->selection_program_id];
        } else {
            $selectionProgramFilter = [$filter, "=", 1];
        }

        if ($request->selection_path_id != null) {
            $selectionPathFilter = ["path.id", "=", $request->selection_path_id];
        } else {
            $selectionPathFilter = [$filter, "=", 1];
        }

        $target = FactRegYearTarget::select(
            DB::raw("SUM(fact_reg_year_target.registration) as total_target")
        )
            ->leftJoin("dim_date as date", "fact_reg_year_target.date_id", "date.id")
            ->where([$yearStartFilter, $yearEndFilter])
            ->first();

        $realization = FactRegRegistration::select(
            DB::raw("SUM(fact_reg_registration.total_participant) as total_realisasi")
        )
            ->leftJoin("dim_date as date", "fact_reg_registration.date_id", "date.id")
            ->leftJoin("dim_selection_paths as path", "fact_reg_registration.selection_path_id", "=", "path.id")
            ->leftJoin("dim_selection_programs as program", "path.selection_program_id", "=", "program.id")
            ->where([$yearStartFilter, $yearEndFilter, $selectionProgramFilter, $selectionPathFilter])
            ->where("fact_reg_registration.registration_status", "=", true)
            ->first();

        $result = [
            'total_target' => (float) $target->total_target,
            'total_realisasi' => $realization->total_realisasi,
        ];

        return response()->json($result, 200);
    }

    //api untuk tahun ajaran
    public function FilterSchoolYear(Request $request)
    {
        $filter = DB::raw('1');

        if ($request->id != null) {
            $id = ['dim_school_year.id', '=', $request->id];
        } else {
            $id = [$filter, '=', '1'];
        }

        if ($request->school_year != null) {
            $school_year = ['dim_school_year.school_year', '=', $request->school_year];
        } else {
            $school_year = [$filter, '=', '1'];
        }

        if ($request->active_status != null) {
            $active_status = ['dim_school_year.active_status', '=', $request->active_status];
        } else {
            $active_status = [$filter, '=', '1'];
        }

        if ($request->start_date != null) {
            $start_date = ['dim_school_year.start_date', '=', $request->start_date];
        } else {
            $start_date = [$filter, '=', '1'];
        }

        if ($request->end_date != null) {
            $end_date = ['dim_school_year.end_date', '=', $request->end_date];
        } else {
            $end_date = [$filter, '=', '1'];
        }

        $data = DimSchoolYear::select(
            'dim_school_year.id',
            'dim_school_year.active_status',
            'dim_school_year.school_year',
            DB::raw("TO_CHAR(dim_school_year.start_date, 'YYYY-MM-DD') AS start_date"),
            DB::raw("TO_CHAR(dim_school_year.end_date, 'YYYY-MM-DD') AS end_date")
        )
            ->where([$id, $school_year, $active_status, $start_date, $end_date])
            ->orderBy('dim_school_year.school_year', 'DESC')
            ->get();

        return response()->json($data, 200);
    }
}
