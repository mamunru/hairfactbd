<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inclinicfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','inclinicid','url','file_real_name'
    ];
}
