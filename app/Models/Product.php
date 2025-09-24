<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'short_description', 
        'description', 
        'regular_price', 
        'sale_price', 
        'sku', 
        'stock_status', 
        'featured', 
        'quantity', 
        'image', 
        'images', 
        'category_id', 
        'brand_id'
    ];

    // Accessor to get images as an array
    public function getImagesArrayAttribute()
    {
        return $this->images ? explode(',', $this->images) : [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
}
