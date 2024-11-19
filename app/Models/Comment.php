<?php

namespace App\Models;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id','comment_id', 'content'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function post(){
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'comment_id','id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'comment_id','id');
    }
}
