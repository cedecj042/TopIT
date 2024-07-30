<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Table;
use App\Models\Question;
use App\Models\Code;
use App\Models\Figure;

class Subsection extends Model
{
    use HasFactory;

    public function sections(){
        return $this->belongsTo(Section::class,'section_id','section_id');
    }
    public function tables(){
        return $this->hasMany(Table::class,'subsection_id');
    }
    public function codes(){
        return $this->hasMany(Code::class,'subsection_id');
    }
    public function figures(){
        return $this->hasMany(Figure::class,'subsection_id');
    }
    public function questions(){
        return $this->hasMany(Question::class,'section_id');
    }
}
