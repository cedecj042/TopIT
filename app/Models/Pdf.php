<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;
class Pdf extends Model
{
    use HasFactory;

    protected $primaryKey='pdf_id';
    protected $fillable = [
        'file_name',
        'file_path',
        'uploaded_by',
    ];

    public function modules(){
        return $this->hasMany(Module::class,'pdf_id');
    }
}
