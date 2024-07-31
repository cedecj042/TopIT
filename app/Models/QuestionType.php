<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;
    protected $primaryKey = 'question_type_id';
    public function questions(){
        return $this->hasMany(Question::class,'question_type_id');
    }
}
