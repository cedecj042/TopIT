<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\QuestionType;
use App\Models\QuestionCategory;
use App\Models\Option;
use App\Models\Test;

class Question extends Model
{
    use HasFactory;
    protected $primaryKey='question_id';
    public function sections(){
       return $this->belongsTo(Section::class,'section_id','section_id');    
    }
    public function tests(){
        return $this->belongsToMany(Test::class,'test_questions','question_id','test_id');
    }
    public function questionable()
    {
        return $this->morphTo();
    }
}
