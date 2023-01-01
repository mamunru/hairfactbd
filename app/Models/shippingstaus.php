<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shippingstaus extends Model
{
    use HasFactory;
    protected $fillable = [
        'txid','status','done'
    ];
}
