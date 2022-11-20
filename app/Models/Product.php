<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'short_desc',
        'long_desc',
        'quantity',
        'regular_price',
        'offer_price',
        'is_featured',
        'product_type',
        'brand_id',
        'category_id',
        'mfg_date',
        'exp_date',
        'sku_code',
        'product_tags',
        'additional_info',
        'status',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
