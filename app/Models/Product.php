<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $fillable = ['vendor_id', 'name', 'slug', 'description', 'is_active'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'LIKE', "%$keyword%");
    }
}
