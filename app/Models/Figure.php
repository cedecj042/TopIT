<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;

class Figure extends Model
{
    use HasFactory;

    public function sections(){
        return $this->belongsTo(Section::class,'section_id','section_id');
    }
    public function subsections(){
        return $this->belongsTo(Subsection::class,'subsection_id','subsection_id');
    }
}
