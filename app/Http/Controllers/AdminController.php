<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamType;
use App\Models\Techonology;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $technology = Techonology::get();
        return view('admin.dashboard', ['technology' => $technology]);
    }

    //technology
    public function addtechnology(Request $request)
    {
        //    dd($request->all());
        $technology = new Techonology();
        $technology->technology = $request->technology;
        $technology->save();

        return redirect('/admin/dashboard')->with('success', 'add successfully');
    }

    public function edittechnology(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $subject = Techonology::where('id', $id)->first();
        $subject->subject = $request->subject;
        $subject->save();

        return redirect('/admin/dashboard')->with('success', 'update successfully');
    }

    public function destroy(string $id)
    {
        $subject = Techonology::where('id', $id)->first();
        $subject->delete();

        return redirect('/admin/dashboard')->with('success', 'Delete successfully');
    }

    //type
    public function exam_type()
    {
        $type = ExamType::get();
        return view('admin.exam_type', ['type' => $type]);
    }

    //technology
    public function addtype(Request $request)
    {
        //    dd($request->all());
        $type = new ExamType();
        $type->type = $request->type;
        $type->slug = Str::slug($request->type);
        $type->marks = $request->marks;
        $type->time = $request->time;
        $type->attempt = $request->attempt;
        $type->save();

        return redirect('/admin/exam_type')->with('success', 'add successfully');
    }

    public function edittype(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $type = ExamType::where('id', $id)->first();
        $type->type = $request->type;
        $type->save();

        return redirect('/admin/exam_type')->with('success', 'update successfully');
    }

    public function exam_type_destroy(string $id)
    {
        $type = ExamType::where('id', $id)->first();
        $type->delete();

        return redirect('/admin/exam_type')->with('success', 'Delete successfully');
    }

    public function examdashboard()
    {
        $technology = Techonology::get();
        $exam = Exam::with('technology')->get();
        return view('admin.examdashboard', ['technology' => $technology, 'exams'=>$exam]);
    }

    public function addexam(Request $request)
    {
        // dd($request->all());
        $exam = new Exam();
        $exam->name = $request->exam_name;
        $exam->slug = Str::slug($request->exam_name);
        $exam->technology_id = $request->technology;

        
        $exam->time = $request->time;
        $exam->date = $request->date;

        $file = $request->file('logo');
        $path = public_path('public/img/');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move($path, $filename);

        $exam->logo = $filename;
        $exam->save();

        return redirect('/admin/exam')->with('success', 'add successfully');
    }

    //question 
    public function qnaDashboard()
    {
        $questions = Question::with(['answers' => function ($query) {
            $query->where('is_correct', 1);
        }, 'exam', 'examtype'])->get();
        $exam = Exam::get();
        $type = ExamType::get();
        // dd($questions);
        // 
        return view('admin.qnaDashboard',['type' => $type, 'exam' => $exam, 'questions'=>$questions]);
    }


    public function addquestion(Request $request)
    {

        // dd($request->answer);
        $question = new Question();
        $question->question = $request->question;
        $question->exam_id = $request->exam_id;
        $question->examtype_id = $request->type_id;
        $question->save();

        foreach ($request->answer as $key => $value) {
            $answer = new Answer();
            $is_correct = 0;
            if ($request->is_correct == $value) {
                $is_correct = 1;
            }

            $answer->question_id = $question->id;
            $answer->answer = $value;
            $answer->is_correct = $is_correct;
            $answer->save();
        }
        return redirect('/admin/q&a')->with('success', 'add question seccessfully');

    }

    public function student()
    {
        $student = User::where('is_admin', 0)->get();
        return view('admin.studentdashboard', ['student' => $student]);
    }
    public function addstudent(Request $request)
    {

        $password = Str::random(8);
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',

        ]);
        if ($validate->fails()) {
            return back()->with(['errors' => $validate->errors()], 422);
        }
        $student = new user();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($password);
        $student->save();

        // $url = Url::to('/');

        // $data['url'] = $url;
        // $data['name'] = $request->name;
        // $data['email'] = $request->email;
        // $data['password'] = $password;
        // $data['title'] = 'Quiz registration';

        // Mail::send('admin.sentmail', compact('data'), function ($mess) use ($data) {
        //     $mess->to($data['email'])->subject($data['title']);
        // });

        return redirect('/admin/student')->with('success', 'add student successfully');
    }

    public function updatestudent(Request $request)
    {
        // dd($request->id);
        $student = User::where('id', $request->id)->first();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->save();

        return redirect('/admin/student')->with('success', 'update student successfully');
    }

    public function deletestudent($id)
    {
        $student = user::where('id', $id)->first();
        $student->delete();
        return redirect('/admin/student')->with('success', 'delete student successfully');
    }
}
