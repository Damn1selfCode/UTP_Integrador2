<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes; // Importa SoftDeletes

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes; // Agrega SoftDeletes

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Define la propiedad $dates para la eliminación suave
    protected $dates = ['deleted_at'];

    //----------------------------cada vez que se estabelzca se cifre
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function getProfileImageAttribute()
    {
        return $this->image
            ? "images/{$this->image->path}"
            : 'https://www.gravatar.com/avatar/404?d=mp';
    }
    //sucripciones
    public function suscripcion()
    {
        return $this->hasOne(Subscription::class, 'user_id', 'id');
    }
    //usuario predeterminado suscripcion 
    public function suscrip()
    {
        return $this->hasOne(Subscription::class);
    }
    /*
    public function suscripcion()
    {
        return $this->hasOne(Suscripcion::class);
    }*/
}
