<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'technology_id', 'date', 'time', 'logo',
    ];
    public function technology()
    {
        return $this->belongsTo(Techonology::class);
    }
    public function question()
    {
        return $this->hasMany(Question::class);
    }
    public function attempt()
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
