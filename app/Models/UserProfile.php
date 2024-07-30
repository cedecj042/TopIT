<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
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
