<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
    ];

    public function user() {        
        return $this->belongsTo(User::class);
    }

    public function images(){        
        return $this->hasMany(Image::class);
    }
    
    public function comments(){        
        return $this->hasMany(Comment::class);
    }
}