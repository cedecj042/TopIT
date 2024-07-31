<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    use HasFactory;
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'firstname',
        'lastname',
        'theta_score',
        'profile_image',
        'birthdate',
        'gender',
        'age',
        'address',
        'school',
        'school_year'
    ];

    public function user(){
        return $this->morphOne(User::class,'userable');
    }
}
