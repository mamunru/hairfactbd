<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','description','catid','subcatid','image','file_real_name','rate','mrp','comisionrate','qnt','remark'    ];
}
