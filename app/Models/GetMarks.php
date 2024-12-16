<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetMarks extends Model
{
    use HasFactory;
    protected $fillable = [
        'attempt_id', 'marks',
    ];
    public function attempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }
   
}
