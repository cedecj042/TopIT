<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiChoiceMany extends Model
{
    use HasFactory;
    protected $primaryKey = 'multichoice_many_id';
    protected $fillable = [
        'name', 
        'answers', 
        'choices',
    ];
    public function question()
    {
        return $this->morphOne(Question::class, 'questionable');
    }
}
