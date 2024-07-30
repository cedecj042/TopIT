<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Option extends Model
{
    use HasFactory;

    public function questions(){
        return $this->belongsToMany(Question::class,'question_options','option_id','question_id');
    }
}
