<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'title',
        'meta_desc',
        'slug',
        'content',
        'price',
        'discount',
        'stock',
        'sku',
        'image',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
