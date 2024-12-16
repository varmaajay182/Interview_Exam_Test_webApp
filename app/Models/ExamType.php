<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type','marks','time','attempt'
    ];
    public function question() {
        return $this->hasMany(Question::class,'examtype_id','id');
    }
    public function answer()
    {
        return $this->hasMany(answer::class);
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
    public function attempt(){
        return $this->hasMany(ExamAttempt::class);
    }
}
