<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'profile_image',
        'last_login'
    ];

    public function users(){
        return $this->morphOne(User::class,'userable');
    }
}
