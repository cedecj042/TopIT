<?php

namespace App\Models;

use Carbon\Traits\Options;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Option;

class Item extends Model
{
    use HasFactory;

    public function questions(){
        return $this->hasMany(Question::class,'question_id','question_id');
    }

    public function options(){
        return $this->hasMany(Options::class,'option_id','option_id');
    }
}
