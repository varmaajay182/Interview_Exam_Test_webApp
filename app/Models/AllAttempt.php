<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllAttempt extends Model
{
    use HasFactory;
    protected $fillable = [
        'attempt_id','attempt_time'
    ];
    public function examattempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'attempt_id');
    }
   
}
