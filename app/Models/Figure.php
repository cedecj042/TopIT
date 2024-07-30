<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;

class Figure extends Model
{
    use HasFactory;

    public function figureable(){
        return $this->morphTo();
    }
}
