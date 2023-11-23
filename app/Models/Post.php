<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion', 
        'imagen',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    }

    public function loves()
    {
        return $this->hasMany(Love::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function checkLove(User $user) 
    {
        return $this->loves->contains('user_id', $user->id);
    }
    public function checkLike(User $user) 
    {
        return $this->likes->contains('user_id', $user->id);
    }
    public function checkDislike(User $user) 
    {
        return $this->dislikes->contains('user_id', $user->id);
    }
    public function checkReport(User $user) 
{
    return $this->reports->contains('user_id', $user->id);
}

    
}
