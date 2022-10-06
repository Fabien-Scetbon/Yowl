<?php

namespace App\Models;

use App\Models\Post;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that have default value.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 0,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */


    protected $fillable = [
        'login',
        'password',
        'email',
        'status'
        
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userPosts()
    {
        return $this->hasMany(Post::class);
    }

    public function userComments()
    {
        return $this->hasMany(Comment::class);
    }


}
