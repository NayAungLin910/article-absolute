<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'header_id',
        'description',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function header() {
        return $this->belongsTo(Header::class);
    }

    public function category() {
        return $this->belongsToMany(Category::class)->latest();
    }

    public function view(){
        return $this->belongsToMany(User::class, 'article_view', 'article_id', 'user_id');
    }

    public function fav() {
        return $this->belongsToMany(User::class, 'article_fav', 'article_id', 'user_id');
    }  

    protected $appends = ["article_created"];
    public function getArticleCreatedAttribute(){
        return  substr($this->created_at, 0, 10);
    }
    
}
