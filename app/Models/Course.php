<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Test;

class Course extends Model
{
    use HasFactory;

    protected $primaryKey= 'course_id';

    protected $fillable = [
        'title',
        'description'
    ];
    public function students(){
        return $this->belongsToMany(Student::class,'student_course_thetas','course_id','student_id');
    }

    public function tests(){
        return $this->belongsTo(Test::class,'course_id');
    }
    public function pdfs(){
        return $this->hasMany(Pdf::class,'course_id','course_id');
    }

    public function modules(){
        return $this->hasMany(Module::class,'course_id','course_id');
    }

    public function questions(){
        return $this->hasMany(Question::class,'course_id','course_id');
    }
}
