<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;


    protected $table = 'posts';
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'url',
        'likes_number'
        
    ];



    public function postCategories()
    {
        return $this->belongsTo(Category::class);
    }
    public function postUsers()
    {
        return $this->belongsTo(User::class);
    }



}
