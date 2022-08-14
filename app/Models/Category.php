<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'slug',
    ];

    public function article()
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
