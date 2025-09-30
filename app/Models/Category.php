<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

     // Relasi One-to-Many dengan Article
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
