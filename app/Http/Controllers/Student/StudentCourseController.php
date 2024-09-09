<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    //
    public function showStudentCourse(){
        $courses = Course::all();
        return view('student.ui.course.course',compact('courses'));
    }
    public function showStudentCourseDetail($id){
        $course = Course::with('modules')->findOrFail($id);
        return view('student.ui.course.course-detail',compact('course'));
    }
    public function showModuleDetail($id)
    {
        $module = Module::with([
            'lessons' => function ($query) {
                $query->with([
                    'sections' => function ($query) {
                        $query->with([
                            'subsections' => function ($query) {
                                $query->with([
                                    'tables.images',
                                    'figures.images',
                                    'codes.images'
                                ]);
                            },
                            'tables.images',
                            'figures.images',
                            'codes.images'
                        ]);
                    }
                ]);
            }
        ])->findOrFail($id);
        $moduleContent = json_decode($module->content, true);
        return view('student.ui.course.module', compact('module','moduleContent'));
    }
       
}
