<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Models\Question;

class Response extends Model
{
    use HasFactory;

    public function tests(){
        return $this->belongsTo(Test::class,'test_id','test_id');
    }

    public function questions(){
        return $this->belongsTo(Question::class,'question_id','question_id');
    }
}
