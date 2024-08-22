<?php

namespace App\Http\Models\ADM\DashboardAdmission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FactRegQuestionAnswer extends Model
{
    protected $table = 'fact_reg_questions_answer';
    protected $connection = 'datamart_dashboard';

    //fungsi untuk get data kuisioner beserta jawabannya
    public static function QuestionWithAnswer()
    {
        $result = array();

        $data = FactRegQuestionAnswer::select(
            "question.id as question_id",
            "question.questions",
            DB::raw("string_agg(distinct answer.id::character varying, ',' order by answer.id::character varying) as answer_tag")
        )
            ->join("dim_list_answer as answer", "fact_reg_questions_answer.answer_id", "=", "answer.id")
            ->join("dim_questions as question", "fact_reg_questions_answer.question_id", "=", "question.id")
            ->groupBy("question.id")
            ->get();

        foreach ($data as $key => $value) {
            //ini array jawaban
            $answerIds = array_map('intval', explode(',', $value["answer_tag"]));
            $answer = DimListAnswer::select("id as answer_id", "name as answer_name")
                ->whereIn("id", $answerIds)
                ->get();

            $resultData = [
                "question_id" => $value["question_id"],
                "question" => $value["questions"],
                "answer" => $answer
            ];

            array_push($result, $resultData);
        }

        return $result;
    }
}
