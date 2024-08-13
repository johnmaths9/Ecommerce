<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'availability',
        'brand',
        'price',
        'old_price',
        'discount_percentage',
        'description',
        'details',
        'category_id',
        'colors',
        'sizes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'discount_percentage' => 'integer',
        'colors' => 'json',
        'sizes' => 'json',
    ];

    // Automatically generate slug before saving to the database
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating')??0;
    }
}
