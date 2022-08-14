<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'file_path',
        'file',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function article(){
        return $this->hasOne(Article::class);
    }
}
