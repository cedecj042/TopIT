<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Course;
class StudentCourseTheta extends Model
{
    use HasFactory;
    
    protected $primaryKey='student_course_theta_id';

    public function students(){
        return $this->belongsTo(Student::class,'student_id','student_id');
    }

    public function courses(){
        return $this->belongsTo(Course::class,'course_id','course_id');
    }
}
