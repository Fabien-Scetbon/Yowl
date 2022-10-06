<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;


    protected $table = 'comments';
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];


    public function commentPosts()
    {
        return $this->belongsTo(Post::class);
    }

    public function commentUsers()
    {
        return $this->belongsTo(User::class);
    }
}
