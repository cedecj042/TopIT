<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;

class Code extends Model
{
    use HasFactory;

    public function codeable(){
        return $this->morphTo();
    }
}
