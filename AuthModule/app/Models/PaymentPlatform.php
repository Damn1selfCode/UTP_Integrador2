<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlatform extends Model
{
    protected $fillable = [
        'name',
        'image',
        'subscription_enabled',

    ];
}