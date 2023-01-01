<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class myorder extends Model
{
    use HasFactory;
    protected $fillable = [
        'mobile', 'address', 'remark', 'user_name', 'name', 'image', 'rate', 'price', 'qty', 'userid', 'status','txid'
    ];
}
