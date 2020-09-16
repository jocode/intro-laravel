<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user(){
        // Un posts pertenece a un usuario
        return $this->belongsTo(User::class);
    }

    public function getGetTitleAttribute(){
        return ucfirst($this->title);
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = strtolower($value);
    }
}
