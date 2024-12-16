<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\ExamType;
use App\Models\GetMarks;
use App\Models\Question;
use Illuminate\Http\Request;

// use Intervention\Image\Facades\Image;

class StudentController extends Controller
{
    public function studentdashboard()
    {
        $exam = Exam::with('technology')->get();

        // dd($question);
        return view('student.dashboard', ['exams' => $exam]);
    }

    public function leveldashboard($slug)
    {
        $id = Exam::where('slug', $slug)->pluck('id');
        $exam = Exam::with('technology')->where('id', $id)->first();
        $level = ExamType::get();
        return view('student.leveldashboard', ['exam' => $exam, 'level' => $level]);
    }

    public function examdashboard(string $level_slug, string $exam_slug)
    {

        $exam_id = Exam::where('slug', $exam_slug)->pluck('id');
        $level_id = ExamType::where('slug', $level_slug)->pluck('id');

        $question = Question::with('answers', 'exam', 'examtype')->where('exam_id', $exam_id)->where('examtype_id', $level_id)->inRandomOrder()->get();
        // dd( count($question));
        if (count($question) == 0) {
            return view('student.examdashboard', ['success' => false, 'mesg' => 'not avaible exam somthing issue', 'question' => $question]);
        } else {

            return view('student.examdashboard', ['question' => $question, 'success' => true]);
        }
    }

    public function saveanswer(Request $request)
    {
        // dd($request->type);
        $attempt = new ExamAttempt();
        $attempt->user_id = session()->get('id');
        $attempt->exam_id = $request->exam_id;
        $attempt->exam_type_id = $request->type;
        $attempt->save();

        foreach ($request->q as $question) {

            if (!empty($request->input('answer_id_' . $question))) {
                $answer = new ExamAnswer();
                $answer->attempt_id = $attempt->id;
                $answer->question_id = $question;

                $answer_id = 'answer_id_' . $question;
                $answer_id_value = $request->$answer_id;

                $answer->answer_id = $answer_id_value;
                $answer->save();
            }

        }
        $check = ExamAnswer::with('answer', 'examattempt')
            ->where('attempt_id', $attempt->id)
            ->whereHas('examattempt', function ($query) use ($request) {
                $query->where('exam_type_id', $request->type);
            })
            ->whereHas('answer', function ($query) use ($request) {
                $query->where('is_correct', 1);
            })->count();

        $getmrks = new GetMarks();

        $getmrks->attempt_id = $attempt->id;
        $getmrks->marks = $check;
        $getmrks->save();

        $exam_id = $request->exam_id;
        $level_id = $request->type + 1;

        if ($level_id < 4) {

            $exam = Exam::find($exam_id);
            if ($exam) {
                // dd($exam->slug);
                $exam_slug = $exam->slug;
            }

            $level = ExamType::find($level_id);
            if ($level) {
                $level_slug = $level->slug;
            }

            return redirect("/student/exam/$level_slug/$exam_slug");

        } else {

            for ($i = 0; $i < 3; $i++) {
                $check = ExamAnswer::with('answer', 'examattempt')
                    ->where('attempt_id', $attempt->id - $i)
                    ->whereHas('examattempt', function ($query) use ($request, $i) {
                        $query->where('exam_type_id', $request->type  - $i);
                    })
                    ->whereHas('answer', function ($query) use ($request) {
                        $query->where('is_correct', 0);
                    })->count();
                    // print($check);
            }
            // dd($check);

            $basic_marks = GetMarks::with('attempt.examtype')
                ->where('attempt_id', $attempt->id - 2)
                ->first();

            $medium_marks = GetMarks::with('attempt.examtype')
                ->where('attempt_id', $attempt->id - 1)
                ->first();

            $hard_marks = GetMarks::with('attempt.examtype')
                ->where('attempt_id', $attempt->id)
                ->first();

            //got marks by student
            $get_basic_marks = $basic_marks->marks * $basic_marks->attempt->examtype->marks;
            $get_medium_marks = $medium_marks->marks * $medium_marks->attempt->examtype->marks;
            $get_hard_marks = $hard_marks->marks * $hard_marks->attempt->examtype->marks;
            // self::certificateGenerate(session()->get('name'));
            $get_total_marks = $get_basic_marks + $get_medium_marks + $get_hard_marks;

            //total marks per level
            $total_basic_question = Question::with('exam', 'examtype')->where('exam_id', $request->exam_id)->where('examtype_id', $basic_marks->attempt->examtype->id)->count();
            $total_medium_question = Question::with('exam', 'examtype')->where('exam_id', $request->exam_id)->where('examtype_id', $medium_marks->attempt->examtype->id)->count();
            $total_hard_question = Question::with('exam', 'examtype')->where('exam_id', $request->exam_id)->where('examtype_id', $hard_marks->attempt->examtype->id)->count();

            $total_basic_marks = $total_basic_question * $basic_marks->attempt->examtype->marks;
            $total_medium_marks = $total_medium_question * $medium_marks->attempt->examtype->marks;
            $total_hard_marks = $total_hard_question * $hard_marks->attempt->examtype->marks;

            $total_marks = $total_basic_marks + $total_medium_marks + $total_hard_marks;

            return view('student.thnakyou', ['get_total_marks' => $get_total_marks, 'basic_marks' => $get_basic_marks, 'medium_marks' => $get_medium_marks, 'hard_marks' => $get_hard_marks, 'total_marks' => $total_marks]);
        }
    }

    public function back()
    {
        return redirect('/dashboard');
    }

    public function wrongquestion()
    {
        return view('student.wrongquestion');
    }
}
