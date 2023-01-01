<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class givebonus extends Model
{
    use HasFactory;
    protected $fillable = [
        'adminid','userid','amount','note'
    ];
}
