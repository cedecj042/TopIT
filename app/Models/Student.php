<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'theta_score',
        'profile_image',
        'birthdate',
        'age',
        'address',
        'school',
        'year',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id','user_id');
    }
}
