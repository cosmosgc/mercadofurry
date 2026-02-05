<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'type',
        'price',
        'available',
        'category_id',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });
    }
    
    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function customStyle()
    {
        return $this->belongsTo(CustomStyle::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function coverImage()
    {
        return $this->hasOne(ProductImage::class)
            ->orderBy('position');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->coverImage && file_exists(public_path($this->coverImage->path))) {
            return asset($this->coverImage->path);
        }

        return asset('images/product-placeholder.png');
    }


}
