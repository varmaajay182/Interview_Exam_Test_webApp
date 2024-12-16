<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'question','exam_id','examtype_id'
    ];
    public function answers() {
        return $this->hasMany(Answer::class);
    }
    public function exam() {
        return $this->belongsTo(exam::class);
    }
    public function examtype() {
        return $this->belongsTo(ExamType::class);
    }
}
