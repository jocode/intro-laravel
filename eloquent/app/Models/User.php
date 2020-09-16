<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Este método, contiene la relación la palabra que tiene el método es la que usará el ORM
    public function posts(){
        // Un usuario puede tener muchos posts
        return $this->hasMany(Post::class);
    }
    
    // Cambiar el  formato de los campos obtenidos
    public function getGetNameAttribute(){
        return ucwords($this->name);
    }

    // Cuando se trate del campo name, quiero que exita esta configuración cuando se guarde los datos
    public function setNameAttribute($value){
        $this->attributes['name'] = strtolower($value);
    }

}
