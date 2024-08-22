<?php

namespace App\Http\Models\ADM\StudentAdmission;

use App\Http\Models\ADM\StudentAdmission\Document_Certificate;
use App\Http\Models\ADM\StudentAdmission\Document_Report_Card;
use App\Http\Models\ADM\StudentAdmission\Document_Study;
use App\Http\Models\ADM\StudentAdmission\Document_Supporting;
use App\Http\Models\ADM\StudentAdmission\Document_Utbk;
use App\Http\Models\ADM\StudentAdmission\Participant_Document;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class New_Student_Document_Type extends Model {
    protected $connection = 'pgsql';
    protected $table = 'new_student_document_type';
    protected $primaryKey = 'id';

    //function for getting participant document for new student
    public static function GetDocumentParticipant($participant_id, $document_type_id)
    {
        $data = Participant_Document::select(
            'participant_documents.id',
            'participant_documents.document_id',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'participant_documents.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('participant_documents.participant_id', '=', $participant_id)
            ->first();

        return $data;
    }

    //function for getting supporting document for new student
    public static function GetDocumentSupporting($registration_number, $document_type_id)
    {
        $data = Document_Supporting::select(
            'document_supporting.id',
            'participant_documents.document_id',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'document_supporting.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('document_supporting.registration_number', '=', $registration_number)
            ->first();

        return $data;
    }

    //function for getting certificate document for new student
    public static function GetDocumentCertificate($registration_number, $document_type_id)
    {
        $data = Document_Certificate::select(
            'document_certificate.id',
            'document_certificate.document_id',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'document_certificate.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('document_certificate.registration_number', '=', $registration_number)
            ->first();

        return $data;
    }

    //function for getting report document for new student
    public static function GetDocumentReportCard($registration_number, $document_type_id)
    {
        $data = Document_Report_Card::select(
            'document_report_card.id',
            'document_report_card.document_id',
            'document_report_card.semester_id',
            'document_report_card.range_score',
            'document_report_card.gpa',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'document_report_card.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('document_report_card.registration_number', '=', $registration_number)
            ->orderBy('document_report_card.semester_id', 'ASC')
            ->get();

        $result = array();

        for ($i=0; $i < 6; $i++) { 
            array_push($result, [
                'id' => (isset($data[$i]) != null) ? $data[$i]['id'] : null,
                'document_id' => (isset($data[$i]) != null) ? $data[$i]['document_id'] : null,
                'semester_id' => (isset($data[$i]) != null) ? $data[$i]['semester_id'] : $i + 1,
                'range_score' => (isset($data[$i]) != null) ? $data[$i]['range_score'] : null,
                'gpa' => (isset($data[$i]) != null) ? $data[$i]['gpa'] : null,
                'document_type_id' => (isset($data[$i]) != null) ? $data[$i]['document_type_id'] : null,
                'url' => (isset($data[$i]) != null) ? $data[$i]['url'] : null,
                'approval_final_status' => (isset($data[$i]) != null) ? $data[$i]['approval_final_status'] : null,
                'approval_final_date' => (isset($data[$i]) != null) ? $data[$i]['approval_final_date'] : null,
                'approval_final_by' => (isset($data[$i]) != null) ? $data[$i]['approval_final_by'] : null,
                'approval_final_comment' => (isset($data[$i]) != null) ? $data[$i]['approval_final_comment'] : null
            ]);
        }

        return $result;
    }

    //function for getting study document for new student
    public static function GetDocumentStudy($registration_number, $document_type_id)
    {
        $data = Document_Study::select(
            'document_study.id',
            'document_study.document_id',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'document_study.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('document_study.registration_number', '=', $registration_number)
            ->first();

        return $data;
    }

    //function for getting utbk document for new student
    public static function GetDocumentUtbk($registration_number, $document_type_id)
    {
        $data = Document_Utbk::select(
            'document_utbk.id',
            'document_utbk.document_id',
            'd.document_type_id',
            'd.url',
            'd.approval_final_status',
            'd.approval_final_date',
            'd.approval_final_by',
            'd.approval_final_comment',
            DB::raw("
            case
                when d.approval_final_comment is not null then 'Ditolak'
                when d.approval_final_status = true then 'Diterima'
                else 'Belum Ditentukan'
            end as approval_status
            ")
        )
            ->join('documents as d', 'document_utbk.document_id', '=', 'd.id')
            ->where('d.document_type_id', '=', $document_type_id)
            ->where('document_utbk.registration_number', '=', $registration_number)
            ->first();

        return $data;
    }
}
?>