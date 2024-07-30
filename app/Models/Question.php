<?php

namespace App\Models;

use Carbon\Traits\Options;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\QuestionType;
use App\Models\QuestionCategory;
use App\Models\Option;
use App\Models\Test;

class Question extends Model
{
    use HasFactory;

    public function sections(){
       return $this->belongsTo(Section::class,'section_id','section_id');    
    }
    public function subsection(){
        return $this->belongsTo(Subsection::class,'subsection_id','subsection_id');
    }

    public function questionType(){
        return $this->belongsTo(QuestionType::class,'question_type_id','question_type_id');
    }
    public function questionCategory(){
        return $this->belongsTo(QuestionCategory::class,'question_category_id','question_category_id');
    }
    public function options(){
        return $this->belongsToMany(Option::class,'question_options','question_id','option_id');
    }
    public function tests(){
        return $this->belongsToMany(Test::class,'test_questions','question_id','test_id');
    }
}
