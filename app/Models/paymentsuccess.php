<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentsuccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'userid', 'txid', 'mobile', 'price','totalprice', 'qty','status'];
}
