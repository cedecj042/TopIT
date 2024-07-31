<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $primaryKey = 'test_id';
    public function users(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }

    public function questions(){
        return $this->belongsToMany(Question::class,'test_questions','test_id','question_id');
    }
}
