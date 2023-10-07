<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'active_until',
        'user_id',
        'plan_id',

    ];
    protected $dates = [
        'active_until',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    //si la suscripcion tiene una fehca activa mayor a la actual
    public function isActive(){
        return $this->active_unitl->gt(now());
    }
}
