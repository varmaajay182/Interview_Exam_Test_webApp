<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/jh', function () {
   
    ExamAttempt::truncate();
   
    
});
Route::get('/', [AuthController::class, 'loadlogin']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/studentregister', [AuthController::class, 'studentregister']);
Route::post('/logincheck', [AuthController::class, 'logincheck']);
Route::get('/google/login', [AuthController::class, 'googleLogin']);
Route::get('/auth/google/callback', [AuthController::class, 'callbackFromGoogle']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/forget_password', [AuthController::class, 'forgetpasswordload']);
Route::post('/forgetpassword', [AuthController::class, 'forgetpassword']);
Route::get('/reset-password', [AuthController::class, 'resetpasswordload']);
Route::post('/resetpassword', [AuthController::class, 'resetpassword']);

//admin route
Route::group(['middleware' => ['web', 'checkadmin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

    //technology route
    Route::post('/addtechnology', [AdminController::class, 'addtechnology']);
    Route::post('/edittechnology', [AdminController::class, 'edittechnology']);
    Route::get('/admin/delete/{id}', [AdminController::class, 'destroy']);

    //type route
    Route::get('/admin/exam_type', [AdminController::class, 'exam_type']);
    Route::post('/addtype', [AdminController::class, 'addtype']);
    Route::post('/edittype', [AdminController::class, 'edittype']);
    Route::get('/admin/exam_type/{id}', [AdminController::class, 'exam_type_destroy']);

    //exam route
    Route::get('/admin/exam', [AdminController::class, 'examdashboard']);
    Route::post('/addexam', [AdminController::class, 'addexam']);

    //qna route
    Route::get('/admin/q&a', [AdminController::class, 'qnaDashboard']);
    Route::post('/addquestion', [AdminController::class, 'addquestion']);

    //student
    Route::get('/admin/student', [AdminController::class, 'student']);
    Route::post('/addstudent', [AdminController::class, 'addstudent']);
    Route::post('/updatestudent', [AdminController::class, 'updatestudent']);
    Route::get('/student/delete/{id}', [AdminController::class, 'deletestudent']);
});

//student route
Route::group(['middleware' => ['web', 'checkstudent']], function () {
    Route::get('/dashboard', [StudentController::class, 'studentdashboard']);

    //level route
    Route::get('/student/level/{slug}', [StudentController::class, 'leveldashboard']);
    Route::get('/student/exam/{level_slug}/{exam_slug}', [StudentController::class, 'examdashboard']);

    //exam/questi'on route
    Route::post('/saveanswer', [StudentController::class, 'saveanswer']);
    Route::get('/back', [StudentController::class, 'back']);
    Route::get('/wrongquestion', [StudentController::class, 'wrongquestion']);
});
