<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notificationhistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid','title','body'
    ];
}
