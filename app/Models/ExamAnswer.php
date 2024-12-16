<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;
    protected $fillable = [
        'attempt_id','question_id','answer_id'
    ];
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
    
    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function examattempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }
}
