<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userprofile extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid',
        'name',
        'image',
        'file_real_name',
        'mobile',
        'email',
        'address',
        'dateofbirth',
        'bmdc'
    ];
}
