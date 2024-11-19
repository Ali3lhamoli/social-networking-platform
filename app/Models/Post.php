<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'image',
        'user_id',
    ];

    public function comments(){
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
    public function likes(){
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
