<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producremark extends Model
{
    use HasFactory;
    protected $fillable = [
        'productid','userid','remarks'];
}
