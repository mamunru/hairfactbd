<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userwallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid','name','mobile','price'
    ];
}
