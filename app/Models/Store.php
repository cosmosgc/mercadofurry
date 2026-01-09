<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'contact_email',
        'contact_discord',
        'contact_telegram',
        'contact_twitter',
        'active',
    ];

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

}
