<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAttempt extends Model
{
    use HasFactory;

    protected $table = 'pretest_attempts';

    protected $primaryKey = 'pretest_id';
    public $incrementing = true;

    protected $fillable = [
        'student_id',
        'answers',
        'score',
    ];

    // If 'answers' are stored as JSON, you might want to cast it to an array
    protected $casts = [
        'answers' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
