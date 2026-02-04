<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'cover_path',
        'contact_email',
        'contact_discord',
        'contact_telegram',
        'contact_twitter',
        'active',
    ];

    protected static function booted()
    {
        static::creating(function ($store) {
            if (empty($store->slug)) {
                $baseSlug = Str::slug($store->name);

                $slug = $baseSlug;
                $count = 1;

                while (static::where('slug', $slug)->exists()) {
                    $slug = "{$baseSlug}-{$count}";
                    $count++;
                }

                $store->slug = $slug;
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function customStyle()
    {
        return $this->belongsTo(CustomStyle::class);
    }
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_path && file_exists(public_path($this->cover_path))) {
            return asset($this->cover_path);
        }

        return asset('images/store-cover-placeholder.png');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


}
