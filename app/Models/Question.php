<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;
use App\Models\QuestionType;
use App\Models\QuestionCategory;
use App\Models\Item;
use App\Models\Response;

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
    public function items(){
        return $this->belongsTo(Item::class,'question_option_id','question_option_id');
    }
    public function responses(){
        return $this->hasMany(Response::class,'question_id','question_id');
    }
}
