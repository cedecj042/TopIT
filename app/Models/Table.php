<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;

class Table extends Model
{
    use HasFactory;
    public function tableable(){
        return $this->morphTo();
    }
}
