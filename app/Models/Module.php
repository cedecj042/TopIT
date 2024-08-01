<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lesson;
use App\Models\Pdf;
class Module extends Model
{
    use HasFactory;
    protected $primaryKey='module_id';
    public function lessons(){
        return $this->hasMany(Lesson::class,'module_id');
    }

    public function pdfs(){
        return $this->belongsTo(Pdf::class,'pdf_id','pdf_id');
    }
}
