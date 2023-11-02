<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscription extends Model
{
    protected $table = 'suscripcion';

    protected $fillable = [
        'suscripcion' // Asegúrate de tener el atributo 'suscripcion' en el array $fillable
        // Otros atributos que permites asignación masiva
    ];

    //registro user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Otros métodos y propiedades del modelo Subscription
}
/*
class Subscription extends Model
{
    protected $table = 'suscripcion';

    //registro user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}*/
