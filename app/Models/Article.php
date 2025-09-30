<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'meta_desc',
        'slug',
        'content',
        'image',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relasi Many-to-One dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi Many-to-One dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}