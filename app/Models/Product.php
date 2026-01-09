<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function customStyle()
    {
        return $this->belongsTo(CustomStyle::class);
    }

}
