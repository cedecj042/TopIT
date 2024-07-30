<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\Subsection;
use App\Models\Table;
use App\Models\Question;
use App\Models\Code;
use App\Models\Figure;


class Section extends Model
{
    use HasFactory;

    public function lessons(){
        return $this->belongsTo(Lesson::class,'lesson_id','lesson_id');
    }
    public function subsections(){
        return $this->hasMany(Subsection::class,'section_id');
    }

    public function tables(){
        return $this->hasMany(Table::class,'section_id');
    }
    public function codes(){
        return $this->hasMany(Code::class,'section_id');
    }
    public function figures(){
        return $this->hasMany(Figure::class,'section_id');
    }
    public function questions(){
        return $this->hasMany(Question::class,'section_id');
    }
}
