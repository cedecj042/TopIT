<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use App\Models\Subsection;

class Table extends Model
{
    use HasFactory;
    protected $primaryKey = 'table_id';
    public function tableable(){
        return $this->morphTo();
    }
}
