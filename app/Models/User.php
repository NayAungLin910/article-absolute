<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function category() {
        return $this->hasMany(Category::class);
    }

    public function article(){
        return $this->hasMany(Article::class);
    }

    public function header(){
        return$this->hasMany(Header::class);
    }

    public function view(){
        return $this->belongsToMany(Article::class, 'article_view', 'user_id', 'article_id');
    }

    public function fav(){
        return $this->belongsToMany(Article::class, 'article_fav', 'user_id', 'article_id');
    }
}
