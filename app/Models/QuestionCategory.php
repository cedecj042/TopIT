<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class QuestionCategory extends Model
{
    use HasFactory;
    protected $primaryKey='question_category_id';
    
    public function questions(){
        return $this->hasMany(Question::class,'question_category_id');
    }
}
