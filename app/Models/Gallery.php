<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Gallery extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',

    ];

    public function user(){     
        return $this->belongsTo(User::class);
    }
    public function images() { 
        return $this->hasMany(Image::class); 
    }
    public function comments(){        
        return $this->hasMany(Comment::class); 
    }
    
    public function scopeSearchByTerm($query, $term = "", $userId = ""){
        $query->with('user', 'images', 'comments');

        if ($userId){
            $query = $query->where('user_id', '=', $userId);
        }

        if (!$term && !$userId){
            return $query;
        }

        return  $query->where(function($querry2) use ($term){
                $querry2->where('title', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%")
                        ->orWhereHas('user', function($querry3) use ($term){
                $querry3->where('first_name', 'like', "%{$term}%")
                        ->orWhere('last_name', 'like', "$%{$term}%");
                });
        });
    }
}