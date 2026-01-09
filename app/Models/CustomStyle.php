<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomStyle extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'tokens',
        'custom_css',
        'is_default',
    ];

    protected $casts = [
        'tokens' => 'array',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

