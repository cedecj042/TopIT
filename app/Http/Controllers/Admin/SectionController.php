<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    //

    public function showSections(){
        return view('admin.ui.course.sections.index');
    }
}
