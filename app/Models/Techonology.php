<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Techonology extends Model
{
    use HasFactory;
    protected $fillable = [
        'technology',
        
    ];
    public function exam()
    {
        return $this->hasOne(Exam::class);
    }

}
